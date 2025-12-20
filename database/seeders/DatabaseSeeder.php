<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleUser = Role::create(['name' => 'user']);
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);
        $user = User::create([
            'name' => 'Super User',
            'email' => 'user@user.com',
            'password' => Hash::make('user'),
        ]);

        $admin->assignRole($roleAdmin);
        $user->assignRole($roleUser);

        Setting::create(['key' => 'app_name', 'value' => 'Rafli CMS', 'type' => 'text', 'group' => 'general']);
        Setting::create(['key' => 'app_description', 'value' => 'Website portfolio keren.', 'type' => 'textarea', 'group' => 'general']);
        Setting::create(['key' => 'app_logo', 'value' => null, 'type' => 'image', 'group' => 'general']);
        Setting::create(['key' => 'theme_color', 'value' => '#0d6efd', 'type' => 'color', 'group' => 'appearance']);
        Setting::create(['key' => 'footer_text', 'value' => '© 2025 Rafli Project', 'type' => 'text', 'group' => 'general']);

        Module::create([
            'name' => 'Services',
            'slug' => 'services',
            'icon' => 'fa-solid fa-briefcase',
            'is_active' => true,
            'form_schema' => [
                ['name' => 'icon', 'type' => 'text', 'label' => 'Icon Class (FontAwesome)'],
                ['name' => 'description', 'type' => 'textarea', 'label' => 'Deskripsi Layanan'],
            ]
        ]);

        Module::create([
            'name' => 'Portfolio',
            'slug' => 'portfolio',
            'icon' => 'fa-solid fa-images',
            'is_active' => true,
            'form_schema' => [
                ['name' => 'client', 'type' => 'text', 'label' => 'Nama Klien'],
                ['name' => 'url', 'type' => 'text', 'label' => 'Link Project'],
                ['name' => 'image', 'type' => 'file', 'label' => 'Screenshot Project'],
                ['name' => 'description', 'type' => 'textarea', 'label' => 'Deskripsi Project'],
            ]
        ]);

        Module::create([
            'name' => 'Teams',
            'slug' => 'teams',
            'icon' => 'fa-solid fa-users',
            'is_active' => true,
            'form_schema' => [
                ['name' => 'position', 'type' => 'text', 'label' => 'Jabatan'],
                ['name' => 'photo', 'type' => 'file', 'label' => 'Foto Profil'],
                ['name' => 'linkedin', 'type' => 'text', 'label' => 'Link LinkedIn'],
            ]
        ]);

        Module::create([
            'name' => 'Testimonials',
            'slug' => 'testimonials',
            'icon' => 'fa-solid fa-star',
            'is_active' => true,
            'form_schema' => [
                ['name' => 'company', 'type' => 'text', 'label' => 'Perusahaan'],
                ['name' => 'quote', 'type' => 'textarea', 'label' => 'Isi Testimoni'],
                ['name' => 'photo', 'type' => 'file', 'label' => 'Foto Klien'],
            ]
        ]);
    }
}
