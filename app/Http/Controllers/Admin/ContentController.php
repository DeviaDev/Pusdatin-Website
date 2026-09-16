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

    public function update(Request $request, ContentGroup $group)
    {
        foreach ($group->fields as $field) {
            if ($field->type === 'image') {
                if ($request->hasFile("fields.$field->id")) {
                    $old = SiteContent::get($field->key);
                    if ($old) Storage::disk('public')->delete($old);
                    $path = $request->file("fields.$field->id")->store('konten', 'public');
                    SiteContent::set($field->key, $path);
                }
            } else {
                SiteContent::set($field->key, $request->input("fields.$field->id"));
            }
        }

        return back()->with('success', 'Konten "' . $group->label . '" berhasil diperbarui.');
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