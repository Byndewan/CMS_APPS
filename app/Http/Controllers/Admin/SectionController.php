<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    // HALAMAN PAGE BUILDER
    public function index()
    {
        $sections = Section::orderBy('order')->get()->groupBy('zone');
        $modules = Module::where('is_active', true)->get();

        return view('admin.sections.index', compact('sections', 'modules'));
    }

    // UPDATE KONTEN SECTION
    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        if ($section->type == 'static') {
            $section->update([
                'title' => $request->title,
                'static_content' => $request->static_content,
                'bg_color' => $request->bg_color
            ]);
        } else {
            $section->update([
                'title' => $request->title,
                'module_id' => $request->module_id,
                'limit_post' => $request->limit_post,
                'bg_color' => $request->bg_color
            ]);
        }

        return redirect()->back()->with('success', 'Section berhasil diperbarui!');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'zone'  => 'required|string'
        ]);

        $items = $request->items;
        $zone  = $request->zone;

        foreach ($items as $index => $id) {
            $section = Section::find($id);
            if ($section) {
                $section->update([
                    'order' => $index + 1,
                    'zone'  => $zone
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
