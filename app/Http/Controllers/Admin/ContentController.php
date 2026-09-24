<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentGroup;
use App\Models\ContentGroupField;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $first = ContentGroup::orderBy('urutan')->first();
        abort_if(!$first, 404, 'Belum ada section konten. Tambahkan dulu.');
        return redirect()->route('admin.konten.edit', $first);
    }

    public function edit(ContentGroup $group)
    {
        $groups = ContentGroup::orderBy('urutan')->get();
        $group->load('fields');
        $values = [];
        foreach ($group->fields as $field) {
            $values[$field->id] = SiteContent::get($field->key);
        }
        return view('admin.konten.edit', compact('group', 'groups', 'values'));
    }

    public function storeGroup(Request $request)
    {
        $data = $request->validate([
            'slug' => 'required|alpha_dash|unique:content_groups,slug',
            'label' => 'required|string|max:255',
        ]);
        $data['urutan'] = ContentGroup::max('urutan') + 1;
        $group = ContentGroup::create($data);

        return redirect()->route('admin.konten.edit', $group)->with('success', 'Section ditambahkan.');
    }

    public function storeField(Request $request, ContentGroup $group)
    {
        $data = $request->validate([
            'key' => 'required|alpha_dash',
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,image',
        ]);
        $data['key'] = $group->slug . '.' . $data['key'];
        $data['urutan'] = $group->fields()->max('urutan') + 1;
        $group->fields()->create($data);

        return back()->with('success', 'Field ditambahkan.');
    }

    public function storeMitra(Request $request, ContentGroup $group)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $nomor = 1;

    while (
        $group->fields()->where('key', $group->slug . '.nama_' . $nomor)->exists() ||
        $group->fields()->where('key', $group->slug . '.logo_' . $nomor)->exists()
    ) {
        $nomor++;
    }

    $namaField = $group->fields()->create([
        'key' => $group->slug . '.nama_' . $nomor,
        'label' => 'Nama Mitra ' . $nomor,
        'type' => 'text',
        'urutan' => $group->fields()->max('urutan') + 1,
    ]);

    $logoField = $group->fields()->create([
        'key' => $group->slug . '.logo_' . $nomor,
        'label' => 'Logo Mitra ' . $nomor,
        'type' => 'image',
        'urutan' => $group->fields()->max('urutan') + 1,
    ]);

    SiteContent::set(
        $namaField->key,
        $request->nama
    );

    $path = $request->file('logo')->store('konten', 'public');

    SiteContent::set(
        $logoField->key,
        $path
    );

    return back()->with(
        'success',
        'Mitra ' . $nomor . ' berhasil ditambahkan.'
    );
}

    public function update(Request $request, ContentGroup $group)
    {
        $group->load('fields');

        foreach ($group->fields as $field) {

            $fieldName = "fields.{$field->id}";

            if ($field->type === 'image') {

                if ($request->hasFile($fieldName)) {

                    $file = $request->file($fieldName);

                    $old = SiteContent::get($field->key);

                    if ($old && Storage::disk('public')->exists($old)) {
                        Storage::disk('public')->delete($old);
                    }

                    $path = $file->store('konten', 'public');

                    SiteContent::set($field->key, $path);
                }
            } else {

                SiteContent::set(
                    $field->key,
                    $request->input($fieldName)
                );
            }
        }

        return back()->with(
            'success',
            'Konten "' . $group->label . '" berhasil diperbarui.'
        );
    }

    public function destroyField(ContentGroupField $field)
    {
        if ($field->type === 'image') {
            $val = SiteContent::get($field->key);
            if ($val) Storage::disk('public')->delete($val);
        }
        SiteContent::where('key', $field->key)->delete();
        $field->delete();

        return back()->with('success', 'Field dihapus.');
    }
}