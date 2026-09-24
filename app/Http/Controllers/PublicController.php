<?php
namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\SopDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PublicController extends Controller
{
    public function beranda()
    {
        $pengumuman = Announcement::published()->take(6)->get();
        return view('public.beranda', compact('pengumuman'));
    }

    public function profil(string $section = 'tentang')
    {
        abort_unless(in_array($section, ['tentang', 'tugas-fungsi', 'visi-misi', 'struktur', 'kontak']), 404);
        return view('public.profil.' . str_replace('-', '_', $section));
    }

    public function kirimKontak(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'instansi' => 'nullable|string|max:255',
        'email' => 'required|email|max:255',
        'subjek' => 'required|string|max:255',
        'pesan' => 'required|string',
    ]);

    return redirect()
        ->route('profil', 'kontak')
        ->with('success', 'Pesan berhasil dikirim.');
    }

    public function informasi()
    {
        $berita = Announcement::published()->paginate(6);
        return view('public.informasi', compact('berita'));
    }

    public function informasiShow(Announcement $announcement)
    {
        abort_unless($announcement->is_published, 404);
        return view('public.informasi-show', compact('announcement'));
    }

    public function sop()
    {
        $sopList = SopDocument::active()
            ->whereDate('published_at', '<=', now()) 
            ->latest('published_at')
            ->get();

        return view('public.sop', compact('sopList'));
    }

    public function sopDownload(SopDocument $sop)
    {
        abort_unless(
            $sop->is_active && $sop->file_path && ($sop->published_at && $sop->published_at->isPast() || $sop->published_at?->isToday()),
            404,
            'Dokumen tidak tersedia.'
        );

        $path = Storage::disk('public')->path($sop->file_path);

        return response()->download(
            $path,
            $sop->file_name ?? $sop->kode . '.pdf'
        );
    }
}
