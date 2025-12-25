<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::orderBy('order')->get()->groupBy('zone');
        $modules = Module::where('is_active', true)->get();

        return view('admin.sections.index', compact('sections', 'modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'zone'  => 'required|string',
            'type'  => 'required|in:static,dynamic',
        ]);

        $lastOrder = Section::where('zone', $request->zone)->max('order');

        Section::create([
            'title' => $request->title,
            'zone'  => $request->zone,
            'type'  => $request->type,
            'bg_color' => $request->bg_color ?? '#ffffff',
            'order' => $lastOrder + 1,
            'module_id' => $request->type == 'dynamic' ? $request->module_id : null,
            'limit_post' => $request->limit_post ?? 5,
            'static_content' => $request->static_content,
        ]);

        return redirect()->back()->with('success', 'Section baru berhasil ditambahkan!');
    }

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

    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->back()->with('success', 'Section berhasil dihapus!');
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
