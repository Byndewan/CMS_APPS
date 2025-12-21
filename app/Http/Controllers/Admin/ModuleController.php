<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    // List Semua Modul
    public function index()
    {
        $modules = Module::all();
        return view('admin.modules.index', compact('modules'));
    }

    // Form Bikin Modul Baru
    public function create()
    {
        return view('admin.modules.create');
    }

    // Simpan Modul Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string',
            'fields' => 'required|array',
            'fields.*.name' => 'required|string',
            'fields.*.type' => 'required|string',
            'fields.*.label' => 'required|string',
        ]);

        $formSchema = [];
        foreach ($request->fields as $field) {
            $formSchema[] = [
                'name' => Str::slug($field['name'], '_'),
                'type' => $field['type'],
                'label' => $field['label']
            ];
        }

        Module::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon,
            'form_schema' => $formSchema,
            'is_active' => true
        ]);

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil dibuat! Refresh halaman untuk lihat menu baru.');
    }
    
    // HALAMAN EDIT
    public function edit($id)
    {
        $module = Module::findOrFail($id);
        return view('admin.modules.edit', compact('module'));
    }

    // PROSES UPDATE
    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string',
            'fields' => 'required|array',
            'fields.*.name' => 'required|string',
            'fields.*.type' => 'required|string',
            'fields.*.label' => 'required|string',
        ]);

        $formSchema = [];
        foreach ($request->fields as $field) {
            $formSchema[] = [
                'name' => Str::slug($field['name'], '_'),
                'type' => $field['type'],
                'label' => $field['label']
            ];
        }

        $module->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'form_schema' => $formSchema,
        ]);

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil diperbarui!');
    }

    // PROSES HAPUS
    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return redirect()->route('admin.modules.index')->with('success', 'Modul dan seluruh datanya berhasil dihapus.');
    }
}
