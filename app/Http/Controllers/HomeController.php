<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;

class HomeController extends Controller
{
    public function index()
    {
        $sections = Section::with(['module.posts' => function($query) {
            $query->where('is_published', true)->latest();
        }])
        ->where('is_active', true)
        ->orderBy('order')
        ->get()
        ->groupBy('zone');

        return view('home', compact('sections'));
    }
}
