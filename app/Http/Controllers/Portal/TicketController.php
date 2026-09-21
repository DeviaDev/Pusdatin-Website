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
        // Jika parameter kategori belum dipilih/kosong, tampilkan halaman pilih kategori
        if (! $kategori) {
            return view('portal.tiket.pilih-kategori');
        }

        // Pastikan kategori yang diakses valid
        abort_unless(isset(self::FORM_FIELDS[$kategori]), 404);

        // Pemetaan kategori ke file Blade form masing-masing di folder portal/tiket/form/
        $views = [
            'hardware'  => 'portal.tiket.form.form-hardware',
            'software'  => 'portal.tiket.form.form-software',
            'jaringan'  => 'portal.tiket.form.form-jaringan',
            'email'     => 'portal.tiket.form.form-email',
            'hak_akses' => 'portal.tiket.form.form-hak-akses',
        ];

        return view($views[$kategori], [
            'kategori'      => $kategori,
            'kategoriLabel' => Ticket::KATEGORI[$kategori],
            'fields'        => self::FORM_FIELDS[$kategori],
        ]);
    }

    public function store(Request $request, string $kategori)
    {
        // Validasi input (lampiran_nodin dibuat opsional/nullable)
        $request->validate([
            'subjek'         => 'nullable|string|max:150',
            'lampiran_nodin' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'lampiran_fpa'   => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'lampiran_spmk'  => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'lampiran'       => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'detail'         => 'required|array',
        ]);

        $ticket = DB::transaction(function () use ($request, $kategori) {
            $year = now()->year;
            $seq  = Ticket::whereYear('created_at', $year)->count() + 1;
            $kode = sprintf('TKT-%s-%03d', $year, $seq);

            $subjek = $request->input('subjek') ?? 'Permohonan ' . Ticket::KATEGORI[$kategori];
            $detailData = $request->input('detail');

            // 1. OTO-GABUNG JAWABAN "Lainnya" & HAPUS FIELD PENDUKUNGNYA
            foreach ($detailData as $key => $value) {
                if ($value === 'Lainnya') {
                    $suffixes = ['_lain', '_keterangan', ' Lain'];
                    foreach ($suffixes as $suffix) {
                        $extraKey = $key . $suffix;
                        if (!empty($detailData[$extraKey])) {
                            $detailData[$key] = 'Lainnya (' . $detailData[$extraKey] . ')';
                            unset($detailData[$extraKey]);
                            break;
                        }
                    }
                }
            }

            // Hapus field pendukung *_lain / *_keterangan yang nilainya kosong
            foreach ($detailData as $key => $val) {
                if ((str_contains($key, '_lain') || str_contains($key, '_keterangan')) && empty($val)) {
                    unset($detailData[$key]);
                }
            }

            // 2. Simpan Tiket Utama
            $ticket = Ticket::create([
                'kode'     => $kode,
                'user_id'  => Auth::id(),
                'kategori' => $kategori,
                'subjek'   => $subjek,
                'detail'   => $detailData,
                'status'   => 'pending',
            ]);

            // 3. MAP LABEL INPUT FILE UNTUK SETIAP FORM
            $drive = app(GoogleDriveService::class);
            $fileLabels = [
                'lampiran_nodin' => ['label' => 'File Nodin', 'folder' => 'nodin'],
                'lampiran_fpa'   => ['label' => 'Form Permohonan Akses (FPA)', 'folder' => 'fpa'],
                'lampiran_spmk'  => ['label' => 'Surat Pernyataan Kerahasian (SPMK)', 'folder' => 'spmk'],
                'lampiran'       => [
                    'label'  => $kategori === 'email' ? 'Screenshot Laman MyASN' : 'Screenshot / Foto Lampiran',
                    'folder' => 'uploadss'
                ],
            ];

            foreach ($fileLabels as $inputName => $info) {
                if ($request->hasFile($inputName)) {
                    $file = $request->file($inputName);
                    $originalName = $file->getClientOriginalName();

                    // Buat Struktur Folder Rapi: tickets/{kategori}/{folder_jenis}/{kode_tiket}/
                    $folderPath = "tickets/{$kategori}/{$info['folder']}/{$ticket->kode}";
                    
                    // Simpan File ke Storage Lokal
                    $localPath = $file->storeAs($folderPath, $originalName, 'local');

                    // Upload ke Google Drive
                    $driveResult = $drive->upload($file, $ticket->kode . '-' . $inputName);

                    if (!$ticket->drive_file_link && !$ticket->local_file_path) {
                        $ticket->update([
                            'drive_file_id'   => $driveResult['file_id'] ?? null,
                            'drive_file_link' => $driveResult['link'] ?? null,
                            'local_file_path' => $localPath,
                        ]);
                    }

                    $detailData['files_uploaded'][$info['label']] = [
                        'file_name'  => $originalName,
                        'drive_link' => $driveResult['link'] ?? null,
                        'local_path' => $localPath,
                    ];
                } else {
                    // Khusus untuk email, jika Screenshot MyASN tidak diisi, catat '-' agar tetap muncul di detail
                    if ($kategori === 'email' && $inputName === 'lampiran') {
                        $detailData['files_uploaded'][$info['label']] = [
                            'file_name'  => null,
                            'drive_link' => null,
                            'local_path' => null,
                        ];
                    }
                }
            }

            // Update detail jika ada data file
            if (isset($detailData['files_uploaded'])) {
                $ticket->update(['detail' => $detailData]);
            }

            // 4. Catat Riwayat Status Awal
            TicketStatusHistory::create([
                'ticket_id'  => $ticket->id,
                'status'     => 'pending',
                'catatan'    => 'Tiket dibuat oleh ' . Auth::user()->nama,
                'changed_by' => Auth::id(),
            ]);

            // 5. Sinkronisasi Google Sheets
            $row = app(GoogleSheetService::class)->appendTicket($ticket->fresh('user'));
            if (is_string($row) && preg_match('/!A(\d+)$/', $row, $m)) {
                $ticket->update(['sheet_row' => (int) $m[1]]);
            }

            return $ticket;
        });

        return redirect()->route('portal.tiket.show', $ticket->id)
            ->with('success', 'Tiket ' . $ticket->kode . ' berhasil dibuat!');
    }

    public function downloadLocal(Request $request, Ticket $tiket)
    {
        // Pastikan hanya pemilik tiket atau admin yang bisa mengunduh
        abort_unless($tiket->user_id === Auth::id() || Auth::user()->isAdmin(), 403);

        // Ambil path spesifik dari query string (jika dikirim), jika tidak pakai default
        $filePath = $request->query('path', $tiket->local_file_path);

        if (!$filePath || !\Illuminate\Support\Facades\Storage::disk('local')->exists($filePath)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        return \Illuminate\Support\Facades\Storage::disk('local')->download($filePath);
    }

    public function show(Ticket $tiket)
    {
        abort_unless($tiket->user_id === Auth::id() || Auth::user()->isAdmin(), 403);
        return view('portal.tiket.show', compact('tiket'));
    }

    public function destroy(Ticket $tiket)
    {
        // Pastikan hanya pemilik tiket atau admin yang bisa menghapus
        abort_unless($tiket->user_id === Auth::id() || Auth::user()->isAdmin(), 403);

        // Opsional: Hanya izinkan hapus jika tiket masih pending
        if ($tiket->status !== 'pending' && !Auth::user()->isAdmin()) {
            return back()->with('error', 'Tiket yang sudah diproses tidak dapat dihapus.');
        }

        // Hapus file lokal jika ada
        if ($tiket->local_file_path && \Illuminate\Support\Facades\Storage::exists($tiket->local_file_path)) {
            \Illuminate\Support\Facades\Storage::delete($tiket->local_file_path);
        }

        // Hapus riwayat & tiket dari database
        $tiket->histories()->delete();
        $tiket->delete();

        return redirect()->route('portal.tiket.index')
            ->with('success', 'Pengaduan ' . $tiket->kode . ' berhasil dihapus.');
    }
}
