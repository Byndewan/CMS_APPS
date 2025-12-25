<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $module->name }} - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root { --font-main: 'Inter', sans-serif; --bg-body: #f8faff; --primary: #3b82f6; }
        body { font-family: var(--font-main); background-color: var(--bg-body); color: #1e293b; }
        .navbar { backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.8); }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; transition: all 0.3s; }
        .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); }
        .page-link { color: var(--primary); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 5px; border: none; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fa-solid fa-cube text-primary me-2"></i>MyCMS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-3 align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active fw-bold" href="#" data-bs-toggle="dropdown">Menu</a>
                        <ul class="dropdown-menu border-0 shadow-sm rounded-3">
                            @foreach($menuModules as $mod)
                                <li>
                                    <a class="dropdown-item py-2 small fw-bold" href="{{ route('front.category', $mod->slug) }}">
                                        <i class="{{ $mod->icon }} me-2 text-primary opacity-50"></i> {{ $mod->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary px-4 rounded-pill fw-bold btn-sm">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="bg-white pt-5 pb-4 mt-5 border-bottom">
        <div class="container mt-4 text-center">
            <div class="d-inline-block p-3 rounded-circle bg-primary-subtle text-primary mb-3">
                <i class="{{ $module->icon }} fa-2x"></i>
            </div>
            <h1 class="fw-bold display-6">{{ $module->name }}</h1>
            <p class="text-muted">Menampilkan semua koleksi {{ strtolower($module->name) }} kami.</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-hover">
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

                        <div class="position-relative" style="height: 200px;">
                            @if($thumb)
                                <img src="{{ $thumb }}" class="w-100 h-100 object-fit-cover" loading="lazy" alt="...">
                            @else
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                    <i class="fa-solid fa-image fa-2x opacity-25"></i>
                                </div>
                            @endif
                            <div class="position-absolute top-0 end-0 m-3 badge bg-white text-dark shadow-sm">
                                {{ $post->created_at->format('d M') }}
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">
                                <a href="{{ route('front.post.show', $post->slug) }}" class="text-decoration-none text-dark stretched-link">
                                    {{ Str::limit($post->title, 50) }}
                                </a>
                            </h5>
                            <p class="small text-muted mb-0">Klik untuk melihat detail lengkap...</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center">
                    <div class="alert alert-light border-0">
                        <i class="fa-solid fa-box-open fa-3x text-muted mb-3 opacity-50"></i>
                        <p class="fw-bold text-muted">Belum ada konten di kategori ini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-end mt-5">
            {{ $posts->links() }}
        </div>
    </div>

    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} {{ config('app.name') }}.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
