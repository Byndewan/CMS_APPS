<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script type="module">
        import hotwiredTurbo from 'https://cdn.skypack.dev/@hotwired/turbo';
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>

    @yield('styles')

    <style>
        :root {
            --bg-body: #f5f7fa;
            --bg-card: #ffffff;
            --text-main: #344767;
            --text-muted: #8392ab;
            --border-color: #e2e8f0;
            --primary-soft: #e9f2ff;
            --primary: #3b82f6;
            --radius: 16px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
        }

        #nprogress .bar {
            background: var(--primary) !important;
            height: 3px !important;
        }
        #nprogress .peg {
            box-shadow: 0 0 10px var(--primary), 0 0 5px var(--primary) !important;
        }
        #nprogress .spinner { display: none; }
        #wrapper {
            display: flex;
            width: 100%;
            transition: all 0.3s;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            width: 260px;
            background: var(--bg-card);
            border-right: 1px solid var(--border-color);
            transition: margin 0.3s;
            position: fixed;
            z-index: 1000;
        }

        .sidebar-heading {
            padding: 1.5rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #page-content-wrapper {
            width: 100%;
            margin-left: 260px;
            transition: margin 0.3s;
        }

        .topbar {
            height: 70px;
            background: var(--bg-body);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
            backdrop-filter: blur(5px);
        }

        .card {
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: 0 2px 6px rgba(0,0,0,0.02) !important;
            background-color: var(--bg-card);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1.2rem 1.5rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .card-body {
            padding: 1.5rem;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: -260px;
        }

        #wrapper.toggled #page-content-wrapper {
            margin-left: 0;
        }

        #menu-toggle i {
            transition: transform 0.3s ease;
        }

        #menu-toggle.active i {
            transform: rotate(180deg);
        }
    </style>
</head>

<body>

    <div class="d-flex" id="wrapper">
        <div id="sidebar-wrapper" data-turbo-permanent>
            <div class="sidebar-heading">
                <i class="fa-solid fa-cube text-primary"></i> My CMS
            </div>
            @include('admin.layouts.sidebar')
        </div>

        <div id="page-content-wrapper">
            <nav class="topbar">
                <button class="btn btn-light border bg-white shadow-sm" id="menu-toggle">
                    <i class="fa-solid fa-bars text-muted"></i>
                </button>
                <div class="dropdown">
                    <button class="btn btn-light border bg-white dropdown-toggle d-flex align-items-center gap-2 shadow-sm"
                        type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center"
                            style="width: 32px; height: 32px;">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="small fw-bold text-muted d-none d-md-block">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-user me-2"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" data-turbo="false">
                                @csrf
                                <button type="submit" class="dropdown-item small text-danger">
                                    <i class="fa-solid fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid px-4 py-4">
                @yield('content')
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener("turbo:click", () => NProgress.start());
        document.addEventListener("turbo:load", () => {
            NProgress.done();
            initSidebarToggle();
            initTooltips();
        });
        document.addEventListener("turbo:submit-start", () => NProgress.start());
        function initSidebarToggle() {
            const wrapper = document.getElementById("wrapper");
            const menuButton = document.getElementById("menu-toggle");
            if(menuButton) {
                const newBtn = menuButton.cloneNode(true);
                menuButton.parentNode.replaceChild(newBtn, menuButton);

                newBtn.addEventListener('click', function() {
                    wrapper.classList.toggle("toggled");
                    this.classList.toggle('active');
                    const icon = this.querySelector('i');
                    if (icon) {
                        // Animasi toggle icon
                        if (icon.classList.contains('fa-bars')) {
                            icon.classList.replace('fa-bars', 'fa-arrow-left');
                        } else {
                            icon.classList.replace('fa-arrow-left', 'fa-bars');
                        }
                    }
                });
            }
        }
        function initTooltips() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        @if (session('success'))
            Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
        @endif
        @if (session('error'))
            Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
        @endif
        document.addEventListener('click', function(e) {
            const target = e.target.closest('.btn-delete');
            if (target) {
                e.preventDefault();
                const form = target.closest('form');
                Swal.fire({
                    title: 'Yakin mau hapus?',
                    text: "Data tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }
        });
        initSidebarToggle();
        initTooltips();

    </script>

    @yield('scripts')

</body>
</html>
