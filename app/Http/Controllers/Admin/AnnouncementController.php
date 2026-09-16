<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;


class AnnouncementController extends Controller
{
    public function index()
    {
        $pengumuman = Announcement::latest()->paginate(15);
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.form', ['item' => new Announcement()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:200',
            'foto' => 'nullable|image|max:2048',
            'isi' => 'required|string',
            'kategori' => 'required|in:Pengumuman,Informasi,Kebijakan',
            'is_published' => 'nullable|boolean',
        ]);
        if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('announcement', 'public');
        }
        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published']) $data['published_at'] = now();

        Announcement::create($data);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman dibuat.');
    }

    public function edit(Announcement $pengumuman)
    {
        return view('admin.pengumuman.form', ['item' => $pengumuman]);
    }

    public function update(Request $request, Announcement $pengumuman)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:200',
            'foto' => 'nullable|image|max:2048',
            'isi' => 'required|string',
            'kategori' => 'required|in:Pengumuman,Informasi,Kebijakan',
            'is_published' => 'nullable|boolean',
        ]);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('announcement', 'public');
        }
        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published'] && ! $pengumuman->published_at) {
            $data['published_at'] = now();
        }
        $pengumuman->update($data);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman diperbarui.');
    }

    public function destroy(Announcement $pengumuman)
    {
        $pengumuman->delete();
        return back()->with('success', 'Pengumuman dihapus.');
    }
}
