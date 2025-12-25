<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Post;

class FrontController extends Controller
{
    public function index()
    {
        $allSections = Section::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();
        foreach ($allSections as $section) {
            if ($section->type === 'dynamic' && $section->module_id) {
                $section->fetched_posts = Post::where('module_id', $section->module_id)
                    ->where('is_published', true)
                    ->latest()
                    ->take($section->limit_post)
                    ->get();
            }
        }
        $sections = $allSections->groupBy('zone');
        $menuModules = \App\Models\Module::all();
        return view('home', compact('sections', 'menuModules'));
    }

    public function category($slug)
    {
        $module = \App\Models\Module::where('slug', $slug)->firstOrFail();
        $posts = \App\Models\Post::where('module_id', $module->id)
            ->where('is_published', true)
            ->latest()
            ->paginate(9);
        $menuModules = \App\Models\Module::all();
        return view('front.category', compact('module', 'posts', 'menuModules'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        return view('front.post_detail', compact('post'));
    }
}
