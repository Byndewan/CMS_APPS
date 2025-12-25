<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - {{ config('app.name') }}</title>

    {{-- FONTS (Inter) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --font-main: 'Inter', sans-serif;
            --bg-body: #f8faff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --primary: #3b82f6;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-body);
            color: var(--text-dark);
        }

        /* Navbar Glass Effect */
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        /* Typography Artikel */
        .article-content {
            font-size: 1.125rem; /* Ukuran font enak baca (18px) */
            line-height: 1.8;    /* Jarak antar baris lega */
            color: #334155;
        }

        .article-title {
            letter-spacing: -0.025em;
            line-height: 1.2;
        }

        /* Sidebar Sticky */
        .sidebar-sticky {
            position: sticky;
            top: 100px; /* Nempel pas discroll */
        }
    </style>
</head>
<body>

    {{-- 1. NAVBAR --}}
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fa-solid fa-cube text-primary me-2"></i>My<span class="text-primary">CMS</span>
            </a>
            <a href="{{ route('home') }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold text-muted">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </nav>

    {{-- SPACER --}}
    <div style="height: 100px;"></div>

    <div class="container mb-5">
        <div class="row g-5"> {{-- g-5 biar jarak kolom kiri-kanan lega --}}

            {{-- KOLOM KIRI: KONTEN UTAMA --}}
            <div class="col-lg-8">

                {{-- Breadcrumb Kecil --}}
                <div class="mb-3 d-flex align-items-center gap-2 text-muted small fw-bold text-uppercase">
                    <span class="text-primary">{{ $post->module->name ?? 'Article' }}</span>
                    <span>&bull;</span>
                    <span>{{ $post->created_at->format('d M Y') }}</span>
                </div>

                {{-- Judul Besar Rata Kiri --}}
                <h1 class="fw-bolder display-5 mb-4 text-dark article-title">{{ $post->title }}</h1>

                {{-- Gambar Utama (Hero Image) --}}
                @php
                    $thumb = null;
                    $content = $post->content ?? [];
                    if(is_array($content)){
                        foreach($content as $val){
                            if(is_string($val) && (str_contains($val, '.jpg') || str_contains($val, '.png'))){
                                $thumb = asset('storage/' . $val);
                                break;
                            }
                        }
                    }
                @endphp

                @if($thumb)
                    <div class="mb-5 rounded-4 overflow-hidden shadow-sm">
                        <img src="{{ $thumb }}" class="w-100 object-fit-cover" style="max-height: 450px;" alt="{{ $post->title }}">
                    </div>
                @endif

                {{-- Isi Artikel --}}
                <article class="article-content">
                    @foreach($post->content as $key => $value)
                        {{-- Skip gambar karena udah di atas --}}
                        @if(is_string($value) && (str_contains($value, '.jpg') || str_contains($value, '.png')))
                            @continue
                        @endif

                        {{-- Render Text --}}
                        <div class="mb-4 text-break">
                            {!! nl2br(e($value)) !!}
                        </div>
                    @endforeach
                </article>
                <hr class="my-5 mt-5 border-secondary-subtle">

            </div>

            {{-- KOLOM KANAN: SIDEBAR (Sticky) --}}
            <div class="col-lg-4">
                <div class="sidebar-sticky">

                    {{-- Card Author --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-uppercase text-muted small mb-3">Tentang Penulis</h6>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fa-solid fa-user-secret fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Admin</h6>
                                    <small class="text-muted">Lead Editor</small>
                                </div>
                            </div>
                            <p class="small text-muted mb-0">
                                Penulis konten resmi yang menyajikan informasi terbaru seputar teknologi dan perkembangan website ini.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <footer class="py-5 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="fw-bold text-dark fs-5"><i class="fa-solid fa-cube text-primary me-2"></i>MyCMS</span>
                    <p class="small text-muted mt-2 mb-0">&copy; {{ date('Y') }} All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
