<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name'    => 'required|string|max:255',
            'app_logo'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'app_favicon' => 'nullable|image|mimes:ico,png|max:1024',
        ]);
        $data = $request->except(['_token', '_method']);
        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('uploads/settings', 'public');
                Setting::updateOrCreate(['key' => $key],['value' => $path,'type'  => 'image','group' => 'general']);
            }
            else {
                if ($key !== 'app_logo' && $key !== 'app_favicon') {
                    Setting::updateOrCreate(['key' => $key],['value' => $value]);
                }
            }
        }

        Cache::flush();

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
