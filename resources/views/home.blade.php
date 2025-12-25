<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'My CMS') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --font-main: 'Inter', sans-serif;
            --bg-body: #f8faff;
            --primary: #3b82f6;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --card-radius: 16px;
            --section-gap: 80px;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-body);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .container {
            max-width: 1520px !important;
        }

        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .section-container {
            padding: 40px 0;
            margin-bottom: 20px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .text-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
                <i class="fa-solid fa-cube text-primary me-2"></i>My<span class="text-primary">CMS</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-3 align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Menu
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm rounded-3">
                            @foreach ($menuModules as $mod)
                                <li>
                                    <a class="dropdown-item py-2 small fw-bold"
                                        href="{{ route('front.category', $mod->slug) }}">
                                        <i class="{{ $mod->icon }} me-2 text-primary opacity-50"></i>
                                        {{ $mod->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @guest
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('login') }}"
                                class="btn btn-primary px-4 rounded-pill fw-bold btn-sm">Login</a>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('admin.dashboard') }}"
                                class="btn btn-outline-primary px-4 rounded-pill fw-bold btn-sm">Dashboard</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 80px;"></div>
    @if (isset($sections['header']))
        <div class="w-100 bg-white border-bottom mb-5">
            <div class="container">
                @foreach ($sections['header'] as $sec)
                    @include('front.section_renderer', ['section' => $sec])
                @endforeach
            </div>
        </div>
    @endif
    @if (isset($sections['hero']))
        <div class="container-fluid px-0 mb-5">
            @foreach ($sections['hero'] as $sec)
                @include('front.section_renderer', ['section' => $sec])
            @endforeach
        </div>
    @endif
    <div class="container mb-5 py-5 px-4 bg-white rounded-4">
        <div class="row g-4">
            @if (isset($sections['sidebar_left']))
                <div class="col-lg-3">
                    <div class="d-flex flex-column gap-4">
                        @foreach ($sections['sidebar_left'] as $sec)
                            @include('front.section_renderer', ['section' => $sec])
                        @endforeach
                    </div>
                </div>
            @endif
            <div
                class="col-lg-{{ isset($sections['sidebar_left']) && isset($sections['sidebar_right']) ? '6' : (isset($sections['sidebar_left']) || isset($sections['sidebar_right']) ? '9' : '12') }}">
                <div class="d-flex flex-column gap-5">
                    @if (isset($sections['main_top']))
                        @foreach ($sections['main_top'] as $sec)
                            @include('front.section_renderer', ['section' => $sec])
                        @endforeach
                    @endif
                    @if (isset($sections['main_center']))
                        @foreach ($sections['main_center'] as $sec)
                            @include('front.section_renderer', ['section' => $sec])
                        @endforeach
                    @endif
                    @if (isset($sections['main_bottom']))
                        @foreach ($sections['main_bottom'] as $sec)
                            @include('front.section_renderer', ['section' => $sec])
                        @endforeach
                    @endif

                </div>
            </div>
            @if (isset($sections['sidebar_right']))
                <div class="col-lg-3">
                    <div class="d-flex flex-column gap-4">
                        @foreach ($sections['sidebar_right'] as $sec)
                            @include('front.section_renderer', ['section' => $sec])
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
    @if (isset($sections['footer']))
        <footer class="bg-white text-dark mt-auto">
            <div class="container">
                @foreach ($sections['footer'] as $sec)
                    @include('front.section_renderer', ['section' => $sec])
                @endforeach
            </div>
        </footer>
    @else
        <footer class="bg-white border-top py-4 mt-5">
            <div class="container text-center text-muted small">
                &copy; {{ date('Y') }} {{ config('app.name') }}.
            </div>
        </footer>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
