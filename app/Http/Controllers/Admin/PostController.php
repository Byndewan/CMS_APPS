<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Post;

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
        dd("Proses Simpan " . $module_slug);
    }
}
