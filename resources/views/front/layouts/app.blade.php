<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ get_setting('app_name') }}</title>

    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --bs-primary: {{ get_setting('theme_color', '#0d6efd') }};
        }

        .btn-primary {
            background-color: var(--bs-primary) !important;
            border-color: var(--bs-primary) !important;
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--bs-primary) !important;
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            {{-- Logo & Judul --}}
            <a class="navbar-brand" href="{{ url('/') }}">
                @if (get_setting('app_logo'))
                    <img src="{{ asset('storage/' . get_setting('app_logo')) }}" height="30" alt="Logo">
                @else
                    {{ get_setting('app_name', 'Starter Pack') }}
                @endif
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white ms-2 px-4"
                            href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- KONTEN --}}
    @yield('content')

    {{-- FOOTER --}}
    {{-- <footer class="bg-light py-4 mt-5 text-center">
        <div class="container">
            <p class="text-muted mb-0">{{ get_setting('footer_text') }}</p>
        </div>
    </footer> --}}

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

</body>

</html>
