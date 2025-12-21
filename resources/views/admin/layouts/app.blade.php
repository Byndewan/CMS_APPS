<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>
    @yield('styles')
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        :root {
            --bs-primary: {{ get_setting('theme_color', '#0d6efd') }};
            --bs-link-color: {{ get_setting('theme_color', '#0d6efd') }};
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            height: 100vh;
        }

        .btn-primary {
            background-color: var(--bs-primary) !important;
            border-color: var(--bs-primary) !important;
        }

        .bg-primary {
            background-color: var(--bs-primary) !important;
        }

        .text-primary {
            color: var(--bs-primary) !important;
        }
    </style>
</head>

<body>

    <div class="admin-wrapper">
        {{-- Sidebar --}}
        @include('admin.layouts.sidebar')

        {{-- Konten --}}
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    @yield('scripts')
</body>

</html>
