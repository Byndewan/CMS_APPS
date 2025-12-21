<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index($module_slug)
    {
        $module = Module::where('slug', $module_slug)->firstOrFail();
        $posts = Post::where('module_id', $module->id)
            ->latest()
            ->paginate(10);
        return view('admin.posts.index', compact('module', 'posts'));
    }

    public function create($module_slug)
    {
        $module = Module::where('slug', $module_slug)->firstOrFail();
        return view('admin.posts.create', compact('module'));
    }

    public function store(Request $request, $module_slug)
    {
        $module = Module::where('slug', $module_slug)->firstOrFail();
        $request->validate([
            'title' => 'required|max:255',
        ]);

        $contentData = $request->input('content', []);
        if ($module->form_schema) {
            foreach ($module->form_schema as $field) {
                if ($field['type'] == 'file') {
                    $fieldName = 'content.' . $field['name'];
                    if ($request->hasFile($fieldName)) {
                        $file = $request->file($fieldName);
                        $path = $file->store('uploads/posts', 'public');
                        $contentData[$field['name']] = $path;
                    }
                }
            }
        }

        // Simpan ke Database
        Post::create([
            'module_id' => $module->id,
            'title'     => $request->title,
            'slug'      => Str::slug($request->title) . '-' . Str::random(5), // Slug unik
            'content'   => $contentData, // Otomatis ubah jadi JSON
            'is_published' => true
        ]);

        return redirect()->route('admin.content.index', $module->slug)
            ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($module_slug, $id)
    {
        $module = Module::where('slug', $module_slug)->firstOrFail();
        $post   = Post::findOrFail($id);
        return view('admin.posts.edit', compact('module', 'post'));
    }

    // PROSES UPDATE DATA
    public function update(Request $request, $module_slug, $id)
    {
        $module = Module::where('slug', $module_slug)->firstOrFail();
        $post   = Post::findOrFail($id);

        // Validasi
        $request->validate([
            'title' => 'required|max:255',
        ]);

        $contentData = $post->content;
        $inputContent = $request->input('content', []);
        $contentData = array_merge($contentData, $inputContent);

        // Handle File Upload
        if ($module->form_schema) {
            foreach ($module->form_schema as $field) {
                if ($field['type'] == 'file') {
                    $fieldName = 'content.' . $field['name'];
                    if ($request->hasFile($fieldName)) {
                        if (isset($contentData[$field['name']])) {
                            Storage::disk('public')->delete($contentData[$field['name']]);
                        }
                        $file = $request->file($fieldName);
                        $path = $file->store('uploads/posts', 'public');
                        $contentData[$field['name']] = $path;
                    }
                }
            }
        }

        // Simpan Perubahan ke DB
        $post->update([
            'title'   => $request->title,
            'content' => $contentData,
        ]);

        return redirect()->route('admin.content.index', $module->slug)->with('success', 'Data berhasil diperbarui!');
    }

    // PROSES HAPUS
    public function destroy($module_slug, $id)
    {
        $post = Post::findOrFail($id);
        if ($post->content) {
            foreach ($post->content as $key => $value) {
                if (is_string($value) && str_contains($value, 'uploads/')) {
                    Storage::disk('public')->delete($value);
                }
            }
        }

        $post->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
