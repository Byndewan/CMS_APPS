# 🚀 My CMS - Ultimate Laravel 11 Dynamic CMS

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)

**My CMS** adalah solusi manajemen konten modern yang dibangun di atas framework **Laravel 11**. Dirancang khusus untuk Developer, Freelancer, atau Agency yang membutuhkan website dinamis, cepat, dan mudah dikustomisasi tanpa perlu menyentuh coding backend yang rumit.

---

## 🔥 Fitur Unggulan

### 1. 🛠️ Dynamic Module Builder (CRUD Generator)
Fitur paling *powerful*! Anda bisa membuat menu admin baru hanya dengan klik-klik.
- **Tanpa Coding:** Buat modul seperti "Produk", "Portfolio", "Event", "Galeri" langsung dari Admin.
- **Custom Fields:** Tentukan sendiri inputnya (Text, Textarea, File Upload/Gambar).
- **Auto Menu:** Modul yang dibuat otomatis muncul di Sidebar Admin & Menu Frontend.

### 2. 🎨 Drag & Drop Page Builder
Atur tata letak halaman depan (Frontend) sesuka hati.
- **Section Management:** Susun blok website (Hero Banner, Services, Testimoni, dll).
- **Live Sorting:** Ubah urutan tampilan dengan *Drag & Drop*.
- **Smart Grid Layout:** Tampilan otomatis menyesuaikan (Full Width / Dengan Sidebar).

### 3. ⚡ High Performance Frontend
- **SPA Feel:** Navigasi admin panel terasa instan tanpa reload halaman (menggunakan Turbo.js).
- **Lazy Loading:** Gambar hanya dimuat saat di-scroll (Skor Google PageSpeed tinggi).
- **SEO Friendly:** Struktur URL yang rapi dan semantic HTML.

---

## 💻 Persyaratan Sistem (Requirements)

Sebelum menginstall, pastikan komputer Anda memiliki:
- **PHP** >= 8.2
- **Composer** (Terbaru)
- **Node.js** & **NPM** (Untuk compile aset CSS/JS)
- **Database:** MySQL / MariaDB (XAMPP/Laragon)

---

## 📦 Cara Install (Localhost)

Ikuti langkah mudah ini untuk menjalankan CMS di komputer Anda:

### 1. Download & Ekstrak
Download source code, lalu buka terminal (CMD/Git Bash) di dalam folder project.

### 2. Install Dependencies
Jalankan perintah berikut untuk menginstall library PHP dan Javascript:
```bash
composer install
npm install
npm run build
```

### 3. Setup Environment (.env)
Copy file .env.example dan ubah namanya menjadi .env.

Buka file .env tersebut, cari bagian Database dan sesuaikan:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_kamu
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Aplikasi & Database
Jalankan perintah ini satu per satu:
```bash
php artisan key:generate
rmdir /s /q public\storage
php artisan storage:link
php artisan migrate:fresh --seed
```

### 5. Jalankan Server
Terminal 1 :
```bash
npm run dev
```

 Terminal 2 :
```bash
php artisan serve
```

Buka browser dan akses: http://localhost:8000

## 🔑 Akun Login Default
Setelah menjalankan perintah migrate:fresh --seed, gunakan akun ini untuk masuk ke Admin Panel:
```bash
Name        | Email           | Password
Super Admin | admin@admin.com | admin
```

## 🛠️ Tech Stack
Backend: Laravel 11 Framework
Frontend: Blade Templating, Bootstrap 5
Interactivity: Hotwire Turbo (SPA Feel), SweetAlert2, SortableJS
Icons: FontAwesome 6 Free

## 📞 Support & Customization
Jika Anda membutuhkan bantuan instalasi atau kustomisasi fitur tambahan, silakan hubungi: 📧 [abyandev657@gmail.com](mailto:abyandev657@gmail.com)
