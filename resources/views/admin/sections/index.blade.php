@extends('admin.layouts.app')

@section('title', 'Page Builder')

@section('styles')
    <style>
        .zone-wrapper {
            min-height: 100px;
            border: 2px dashed #cbd5e1;
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }

        .zone-wrapper:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        .zone-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 10px;
            font-weight: bold;
            display: block;
        }

        .section-item {
            cursor: move;
        }

        .preview-container {
            border: 10px solid #333;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            height: 600px;
            position: relative;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        .nav-pills .nav-link:not(.active) {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            background-color: #fff;
            color: #333;
            transition: all 0.2s ease;
        }

        .nav-pills .nav-link.active {
            box-shadow: none;
        }

        .nav-pills .nav-link:not(.active):hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <h2 class="mb-0">Page Builder</h2>
                <button class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#createSectionModal">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Section
                </button>
            </div>
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="pills-edit-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-edit" type="button" role="tab">
                        <i class="fa-solid fa-pen-ruler me-2"></i> Editor Mode
                    </button>
                </li>
                <li class="nav-item mx-1" role="presentation">
                    <button class="nav-link fw-bold" id="pills-preview-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-preview" type="button" role="tab" onclick="loadPreview()">
                        <i class="fa-solid fa-eye me-2"></i> Live Preview
                    </button>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-edit" role="tabpanel">
                <div class="zone-wrapper" id="header" data-zone="header">
                    <span class="zone-label"><i class="fa-solid fa-heading me-1"></i> Header Zone</span>
                    @include('admin.sections.item_renderer', ['items' => $sections['header'] ?? []])
                </div>
                <div class="zone-wrapper" id="hero" data-zone="hero">
                    <span class="zone-label"><i class="fa-solid fa-image me-1"></i> Hero Banner Zone</span>
                    @include('admin.sections.item_renderer', ['items' => $sections['hero'] ?? []])
                </div>

                {{-- BODY CONTAINER --}}
                <div class="row">
                    {{-- Sidebar Left --}}
                    <div class="col-md-3">
                        <div class="zone-wrapper h-100" id="sidebar_left" data-zone="sidebar_left">
                            <span class="zone-label">Sidebar Left</span>
                            @include('admin.sections.item_renderer', [
                                'items' => $sections['sidebar_left'] ?? [],
                            ])
                        </div>
                    </div>

                    {{-- Center Content --}}
                    <div class="col-md-6">
                        <div class="zone-wrapper" id="main_top" data-zone="main_top">
                            <span class="zone-label">Main Content - Top</span>
                            @include('admin.sections.item_renderer', [
                                'items' => $sections['main_top'] ?? [],
                            ])
                        </div>

                        <div class="zone-wrapper" id="main_center" data-zone="main_center">
                            <span class="zone-label">Main Content - Center (Primary)</span>
                            @include('admin.sections.item_renderer', [
                                'items' => $sections['main_center'] ?? [],
                            ])
                        </div>

                        <div class="zone-wrapper" id="main_bottom" data-zone="main_bottom">
                            <span class="zone-label">Main Content - Bottom</span>
                            @include('admin.sections.item_renderer', [
                                'items' => $sections['main_bottom'] ?? [],
                            ])
                        </div>
                    </div>

                    {{-- Sidebar Right --}}
                    <div class="col-md-3">
                        <div class="zone-wrapper h-100" id="sidebar_right" data-zone="sidebar_right">
                            <span class="zone-label">Sidebar Right</span>
                            @include('admin.sections.item_renderer', [
                                'items' => $sections['sidebar_right'] ?? [],
                            ])
                        </div>
                    </div>
                </div>
                <div class="zone-wrapper" id="footer" data-zone="footer">
                    <span class="zone-label"><i class="fa-solid fa-shoe-prints me-1"></i> Footer Zone</span>
                    @include('admin.sections.item_renderer', ['items' => $sections['footer'] ?? []])
                </div>
            </div>
            <div class="tab-pane fade" id="pills-preview" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="mb-0 text-muted small"><i class="fa-solid fa-info-circle me-1"></i> Ini adalah tampilan
                        website saat ini. Bisa di lihat disini atau klik link ini <a style="text-decoration: none"
                            target="_blank" href="{{ route('home') }}">HALAMAN DEPAN</a> </p>
                    <button class="btn btn-sm btn-dark" onclick="refreshPreview()">
                        <i class="fa-solid fa-rotate me-1"></i> Refresh Preview
                    </button>
                </div>

                <div class="preview-container shadow">
                    <div id="preview-loader" class="loading-overlay">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <iframe id="site-preview" src="" title="Website Preview"></iframe>
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL CREATE SECTION BARU --}}
    <div class="modal fade" id="createSectionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.sections.store') }}" method="POST">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Section Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Judul Section (Internal)</label>
                                <input type="text" name="title" class="form-control"
                                    placeholder="Misal: Slider Produk" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Zona Lokasi</label>
                                <select name="zone" class="form-select bg-light">
                                    <option value="header">Header Zone</option>
                                    <option value="hero">Hero Banner Zone</option>
                                    <option value="sidebar_left">Sidebar Left</option>
                                    <option value="main_top">Main Content - Top</option>
                                    <option value="main_center" selected>Main Content - Center (Primary)</option>
                                    <option value="main_bottom">Main Content - Bottom</option>
                                    <option value="sidebar_right">Sidebar Right</option>
                                    <option value="footer">Footer Zone</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tipe Konten</label>
                                <select name="type" class="form-select" id="createTypeSelector"
                                    onchange="toggleCreateType()">
                                    <option value="dynamic">Dinamis (Ambil dari Modul)</option>
                                    <option value="static">Statis (Teks/HTML Manual)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Background Color</label>
                                <input type="color" name="bg_color" class="form-control form-control-color w-100"
                                    value="#ffffff">
                            </div>
                        </div>
                        <hr>
                        <div id="createDynamicOptions">
                            <div class="alert alert-info border-0 small">
                                <i class="fa-solid fa-info-circle me-1"></i>
                                Pilih modul konten yang ingin ditampilkan.
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold">Pilih Modul</label>
                                    <select name="module_id" class="form-select">
                                        @foreach ($modules as $mod)
                                            <option value="{{ $mod->id }}">{{ $mod->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Jumlah Tampil</label>
                                    <input type="number" name="limit_post" class="form-control" value="5">
                                </div>
                            </div>
                        </div>
                        <div id="createStaticOptions" style="display: none;">
                            <div class="alert alert-warning border-0 small">
                                <i class="fa-solid fa-code me-1"></i>
                                Tulis HTML manual atau teks biasa.
                            </div>
                            <label class="form-label small fw-bold">Konten HTML</label>
                            <textarea name="static_content" class="form-control" rows="5" placeholder="<h1>Halo Dunia</h1>"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Tambah Section</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // SORTABLE (DRAG & DROP)
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Sortable === 'undefined') return;
            const zones = document.querySelectorAll('.zone-wrapper');
            zones.forEach(zone => {
                new Sortable(zone, {
                    group: 'sections',
                    animation: 150,
                    draggable: '.section-item',
                    handle: '.card-body',
                    ghostClass: 'bg-light',
                    onEnd: function(evt) {
                        let newZone = evt.to;
                        let zoneName = newZone.getAttribute('data-zone');
                        let orderIds = Array.from(newZone.children)
                            .filter(child => child.classList.contains('section-item'))
                            .map(item => item.getAttribute('data-id'));
                        fetch("{{ route('admin.sections.reorder') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                items: orderIds,
                                zone: zoneName
                            })
                        });
                    }
                });
            });
        });

        // LAZY LOAD PREVIEW
        let isPreviewLoaded = false;

        function loadPreview() {
            const iframe = document.getElementById('site-preview');
            const loader = document.getElementById('preview-loader');
            if (!isPreviewLoaded) {
                iframe.src = "{{ url('/') }}";
                iframe.onload = function() {
                    loader.style.display = 'none';
                };
                isPreviewLoaded = true;
            }
        }

        function refreshPreview() {
            const iframe = document.getElementById('site-preview');
            const loader = document.getElementById('preview-loader');

            loader.style.display = 'flex';
            iframe.src = iframe.src;
        }
    </script>
@endsection
