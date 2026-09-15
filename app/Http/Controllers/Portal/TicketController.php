<?php
namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketStatusHistory;
use App\Services\GoogleDriveService;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /** Form tiap kategori punya field berbeda. */
    private const FORM_FIELDS = [
        'hardware' => [
            'jenis_perangkat' => ['label' => 'Jenis Perangkat', 'type' => 'select', 'options' => ['Komputer', 'Laptop', 'Printer', 'Scanner', 'Monitor', 'Lainnya'], 'required' => true],
            'merk_tipe'       => ['label' => 'Merk / Tipe', 'type' => 'text', 'required' => true],
            'no_inventaris'   => ['label' => 'Nomor Inventaris', 'type' => 'text', 'required' => false],
            'lokasi'          => ['label' => 'Lokasi / Unit Kerja', 'type' => 'text', 'required' => true],
            'deskripsi'       => ['label' => 'Deskripsi Gangguan', 'type' => 'textarea', 'required' => true],
        ],
        'software' => [
            'jenis_sistem'    => ['label' => 'Jenis Sistem', 'type' => 'select', 'options' => ['Sistem Operasi', 'Aplikasi Operasional', 'Aplikasi Pendukung (Office, dsb)'], 'required' => true],
            'nama_aplikasi'   => ['label' => 'Nama Aplikasi / Sistem', 'type' => 'text', 'required' => true],
            'versi'           => ['label' => 'Versi', 'type' => 'text', 'required' => false],
            'lokasi'          => ['label' => 'Lokasi / Unit Kerja', 'type' => 'text', 'required' => true],
            'deskripsi'       => ['label' => 'Deskripsi Gangguan', 'type' => 'textarea', 'required' => true],
        ],
        'jaringan' => [
            'jenis_gangguan'  => ['label' => 'Jenis Gangguan', 'type' => 'select', 'options' => ['Kabel LAN', 'WiFi', 'Internet', 'VPN', 'Server / Switch / Router', 'Lainnya'], 'required' => true],
            'lokasi'          => ['label' => 'Lokasi / Unit Kerja', 'type' => 'text', 'required' => true],
            'waktu_kejadian'  => ['label' => 'Waktu Kejadian', 'type' => 'datetime-local', 'required' => false],
            'deskripsi'       => ['label' => 'Deskripsi Gangguan', 'type' => 'textarea', 'required' => true],
        ],
        'email' => [
            'jenis_layanan'   => ['label' => 'Jenis Layanan', 'type' => 'select', 'options' => ['Reset Password', 'Pembuatan Akun Baru', 'Kendala Akses / Kirim-Terima', 'Perubahan Data Akun', 'Lainnya'], 'required' => true],
            'email_terkait'   => ['label' => 'Alamat Email yang Bersangkutan', 'type' => 'email', 'required' => true],
            'deskripsi'       => ['label' => 'Deskripsi', 'type' => 'textarea', 'required' => true],
        ],
        'hak_akses' => [
            'jenis_akses'     => ['label' => 'Jenis Hak Akses', 'type' => 'select', 'options' => ['VPN', 'Network / Database', 'Internet', 'Folder / Drive', 'Aplikasi Internal', 'Akses Kantor & Ruang Pusat Data'], 'required' => true],
            'sistem_tujuan'   => ['label' => 'Sistem / Aplikasi Tujuan', 'type' => 'text', 'required' => true],
            'alasan'          => ['label' => 'Alasan / Dasar Permintaan', 'type' => 'textarea', 'required' => true],
            'deskripsi'       => ['label' => 'Deskripsi Kebutuhan', 'type' => 'textarea', 'required' => true],
        ],
    ];

    public function index()
    {
        $tiket = Auth::user()->tickets()->latest()->paginate(10);
        return view('portal.tiket.index', compact('tiket'));
    }

    public function create(string $kategori = null)
    {
        if (! $kategori) {
            return view('portal.tiket.pilih-kategori');
        }
        abort_unless(isset(self::FORM_FIELDS[$kategori]), 404);
        return view('portal.tiket.create', [
            'kategori' => $kategori,
            'kategoriLabel' => Ticket::KATEGORI[$kategori],
            'fields' => self::FORM_FIELDS[$kategori],
        ]);
    }

    public function store(Request $request, string $kategori)
    {
        abort_unless(isset(self::FORM_FIELDS[$kategori]), 404);
        $fields = self::FORM_FIELDS[$kategori];

        $rules = ['subjek' => 'required|string|max:150', 'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120'];
        foreach ($fields as $name => $f) {
            $rules['detail.' . $name] = ($f['required'] ? 'required' : 'nullable') . '|string|max:1000';
        }
        $request->validate($rules, [], ['subjek' => 'Subjek']);

        $ticket = DB::transaction(function () use ($request, $kategori) {
            $year = now()->year;
            $seq = Ticket::whereYear('created_at', $year)->count() + 1;
            $kode = sprintf('TKT-%s-%03d', $year, $seq);

            $ticket = Ticket::create([
                'kode' => $kode,
                'user_id' => Auth::id(),
                'kategori' => $kategori,
                'subjek' => $request->subjek,
                'detail' => $request->input('detail'),
                'status' => 'pending',
            ]);

            // Lampiran → Google Drive (atau lokal sebagai fallback)
            if ($request->hasFile('lampiran')) {
                $drive = app(GoogleDriveService::class);
                $result = $drive->upload($request->file('lampiran'), $ticket->kode);
                $ticket->update([
                    'drive_file_id' => $result['file_id'],
                    'drive_file_link' => $result['link'],
                    'local_file_path' => $result['local_path'],
                ]);
            }

            // Riwayat awal
            TicketStatusHistory::create([
                'ticket_id' => $ticket->id,
                'status' => 'pending',
                'catatan' => 'Tiket dibuat oleh ' . Auth::user()->nama,
                'changed_by' => Auth::id(),
            ]);

            // Kirim ke Google Sheets
            $row = app(GoogleSheetService::class)->appendTicket($ticket->fresh('user'));
            if (is_string($row) && preg_match('/!A(\d+)$/', $row, $m)) {
                $ticket->update(['sheet_row' => (int) $m[1]]);
            }

            return $ticket;
        });

        return redirect()->route('portal.tiket.show', $ticket->id)
            ->with('success', 'Tiket ' . $ticket->kode . ' berhasil dibuat!');
    }

    public function show(Ticket $tiket)
    {
        abort_unless($tiket->user_id === Auth::id() || Auth::user()->isAdmin(), 403);
        return view('portal.tiket.show', compact('tiket'));
    }
}
