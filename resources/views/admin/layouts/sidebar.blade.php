<div class="list-group list-group-flush px-3 py-2">
    <small class="text-uppercase text-muted fw-bold mb-2 mt-2 ps-3" style="font-size: 0.7rem; letter-spacing: 1px;">Main Menu</small>
    <a href="{{ route('admin.dashboard') }}"
       class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
        <i class="fa-solid fa-gauge me-2"></i> Dashboard
    </a>
    <a href="{{ route('admin.sections.index') }}"
       class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('admin.sections*') ? 'active-menu' : '' }}">
        <i class="fa-solid fa-layer-group me-2"></i> Page Builder
    </a>
    <a href="{{ route('admin.modules.index') }}"
       class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('admin.modules*') ? 'active-menu' : '' }}">
        <i class="fa-solid fa-box-open me-2"></i> Modules
    </a>
    <small class="text-uppercase text-muted fw-bold mb-2 mt-3 ps-3" style="font-size: 0.7rem; letter-spacing: 1px;">Content</small>
    @foreach(\App\Models\Module::where('is_active', true)->get() as $mod)
        <a href="{{ route('admin.content.index', $mod->slug) }}"
           class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->is('admin/content/'.$mod->slug.'*') ? 'active-menu' : '' }}">
            <i class="{{ $mod->icon }} me-2"></i> {{ $mod->name }}
        </a>
    @endforeach
</div>

<style>
    .list-group-item {
        color: var(--text-main);
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .list-group-item:hover {
        background-color: var(--bg-body);
        color: var(--primary);
    }
    .active-menu {
        background-color: var(--primary-soft) !important;
        color: var(--primary) !important;
        font-weight: 600;
    }
</style>
