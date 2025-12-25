<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Post;
use App\Models\Section;

class DashboardController extends Controller
{
    public function index()
    {
        $totalModules = Module::count();
        $totalPosts = Post::count();
        $totalSections = Section::count();
        $latestPosts = Post::with('module')->latest()->take(5)->get();
        return view('admin.dashboard', compact('totalModules', 'totalPosts', 'totalSections', 'latestPosts'));
    }
}
