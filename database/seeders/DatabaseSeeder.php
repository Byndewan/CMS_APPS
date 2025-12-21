<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Section;
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

        Setting::create(['key' => 'app_name', 'value' => 'Abyan CMS', 'type' => 'text', 'group' => 'general']);
        Setting::create(['key' => 'app_description', 'value' => 'Website portfolio keren.', 'type' => 'textarea', 'group' => 'general']);
        Setting::create(['key' => 'app_logo', 'value' => null, 'type' => 'image', 'group' => 'general']);
        Setting::create(['key' => 'theme_color', 'value' => '#0d6efd', 'type' => 'color', 'group' => 'appearance']);
        Setting::create(['key' => 'footer_text', 'value' => '© 2025 Abyan Project', 'type' => 'text', 'group' => 'general']);

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

        // --- SEEDER SECTIONS ---

        // HEADER
        \App\Models\Section::create([
            'title' => 'Top Bar Promo',
            'zone'  => 'header', // MUNCUL DI PALING ATAS
            'type'  => 'static',
            'static_content' => '<div class="alert alert-warning text-center m-0 small">Promo pembuatan web diskon 20% bulan ini!</div>',
            'order' => 1,
        ]);

        // HERO BANNER
        \App\Models\Section::create([
            'title' => 'Hero Banner',
            'zone'  => 'main_top', // MUNCUL DI ATAS TENGAH
            'type'  => 'static',
            'static_content' => '<div class="p-5 mb-4 bg-light rounded-3 text-center"><h1 class="display-5 fw-bold">Selamat Datang di Abyan CMS</h1><p class="fs-4">Solusi website dinamis dengan layout 9 Zona.</p></div>',
            'order' => 1,
        ]);

        // SIDEBAR KIRI
        \App\Models\Section::create([
            'title' => 'Tentang Admin',
            'zone'  => 'sidebar_left', // MUNCUL DI KIRI
            'type'  => 'static',
            'static_content' => '<div class="card mb-3"><div class="card-header bg-primary text-white">Admin</div><div class="card-body"><p>Halo, saya Abyan Lead Developer project ini.</p></div></div>',
            'order' => 1,
        ]);

        // KONTEN UTAMA
        $serviceModule = \App\Models\Module::where('slug', 'services')->first();
        if ($serviceModule) {
            \App\Models\Section::create([
                'title' => 'Layanan Kami',
                'zone'  => 'main_center', // MUNCUL DI TENGAH UTAMA
                'type'  => 'dynamic',
                'module_id' => $serviceModule->id,
                'limit_post' => 3,
                'order' => 1,
            ]);
        }

        // SIDEBAR KANAN
        \App\Models\Section::create([
            'title' => 'Info Penting',
            'zone'  => 'sidebar_right', // MUNCUL DI KANAN
            'type'  => 'static',
            'static_content' => '<div class="card border-info mb-3"><div class="card-body text-info"><h5 class="card-title">Jam Kerja</h5><p class="card-text">Senin - Jumat<br>09.00 - 17.00</p></div></div>',
            'order' => 1,
        ]);

        // FOOTER
        \App\Models\Section::create([
            'title' => 'Footer Copyright',
            'zone'  => 'footer', // MUNCUL DI PALING BAWAH
            'type'  => 'static',
            'static_content' => '<footer class="py-3 my-4 border-top text-center"><p class="text-muted">© 2025 Abyan CMS Company, Inc</p></footer>',
            'order' => 1,
        ]);
    }
}
