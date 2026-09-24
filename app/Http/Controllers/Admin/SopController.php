<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SopDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SopController extends Controller
{
    public function index()
    {
        $sop = SopDocument::latest('published_at')->paginate(15);
        return view('admin.sop.index', compact('sop'));
    }

    public function create()
    {
        return view('admin.sop.form', ['item' => new SopDocument()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('sop', 'public');
            $data['file_name'] = $request->file('file')->getClientOriginalName();
        }
        $data['is_active'] = $request->boolean('is_active');
        
        SopDocument::create($data);
        return redirect()->route('admin.sop.index')->with('success', 'Dokumen SOP ditambahkan.');
    }

    public function edit(SopDocument $sop)
    {
        return view('admin.sop.form', ['item' => $sop]);
    }

    public function update(Request $request, SopDocument $sop)
    {
        $data = $this->validateData($request, $sop->id);
        if ($request->hasFile('file')) {
            if ($sop->file_path) Storage::disk('public')->delete($sop->file_path);
            $data['file_path'] = $request->file('file')->store('sop', 'public');
            $data['file_name'] = $request->file('file')->getClientOriginalName();
        }
        $data['is_active'] = $request->boolean('is_active');

        $sop->update($data);
        return redirect()->route('admin.sop.index')->with('success', 'Dokumen SOP diperbarui.');
    }

    public function destroy(SopDocument $sop)
    {
        if ($sop->file_path) Storage::disk('public')->delete($sop->file_path);
        $sop->delete();
        return back()->with('success', 'Dokumen SOP dihapus.');
    }

    public function download(SopDocument $sop)
    {
        abort_unless($sop->file_path && Storage::disk('public')->exists($sop->file_path), 404, 'File tidak tersedia.');
        return Storage::disk('public')->download($sop->file_path, $sop->file_name ?? $sop->kode . '.pdf');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'kode' => 'required|string|max:50|unique:sop_documents,kode' . ($ignoreId ? ',' . $ignoreId : ''),
            'nama' => 'required|string|max:200',
            'klasifikasi' => 'required|string|max:100',
            'published_at' => 'required|date',
            'deskripsi' => 'nullable|string|max:5000',
            'file' => ($ignoreId ? 'nullable' : 'required') . '|file|mimes:pdf,png,jpg,jpeg|max:10240',
        ], [
            'file.required' => 'File dokumen wajib diunggah.',
            'file.mimes' => 'Format file harus berupa PDF, PNG, JPG, atau JPEG.',
            'file.max' => 'Ukuran file maksimal 10MB.'
        ]);
    }
}