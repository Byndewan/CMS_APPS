<div class="d-flex flex-column flex-shrink-0 p-3 bg-white border-end vh-100" style="width: 280px;">
    {{-- LOGO / JUDUL --}}
    <a href="/admin/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <span class="fs-4 fw-bold text-primary">{{ get_setting('app_name', 'Rafli CMS') }}</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/admin/dashboard" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : 'link-dark' }}">
                <i class="fa-solid fa-home me-2"></i> Dashboard
            </a>
        </li>

        {{-- HEADER KONTEN --}}
        <li class="nav-header text-muted mt-3 ms-2 text-uppercase" style="font-size: 0.75rem;">Content Modules</li>
        @foreach($sidebar_modules as $module)
            <li class="nav-item">
                <a href="{{ route('admin.content.index', $module->slug) }}"
                   class="nav-link {{ request()->is('admin/content/'.$module->slug.'*') ? 'active' : 'link-dark' }}">
                    <i class="{{ $module->icon ?? 'fa-solid fa-folder' }} me-2"></i>
                    {{ $module->name }}
                </a>
            </li>
        @endforeach

        {{-- HEADER SYSTEM --}}
        <li class="nav-header text-muted mt-3 ms-2 text-uppercase" style="font-size: 0.75rem;">System</li>
        <li>
            <a href="#" class="nav-link link-dark">
                <i class="fa-solid fa-layer-group me-2"></i> Sections
            </a>
        </li>
        <li>
            <a href="#" class="nav-link link-dark">
                <i class="fa-solid fa-tools me-2"></i> Module Builder
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/settings') }}" class="nav-link {{ request()->is('admin/settings') ? 'active' : 'link-dark' }}">
                <i class="fa-solid fa-cog me-2"></i> Settings
            </a>
        </li>
    </ul>
    <hr>

    {{-- USER DROPDOWN --}}
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://ui-avatars.com/api/?name=Admin" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">Sign out</button>
                </form>
            </li>
        </ul>
    </div>
</div>
