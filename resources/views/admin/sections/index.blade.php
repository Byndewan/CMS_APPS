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

        {{-- HEADER & TABS NAVIGASI --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Page Builder</h2>

            {{-- TOMBOL TAB --}}
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

        {{-- ISI TABS --}}
        <div class="tab-content" id="pills-tabContent">

            {{-- TAB 1: EDITOR MODE (Drag & Drop) --}}
            <div class="tab-pane fade show active" id="pills-edit" role="tabpanel">

                {{-- ZONE HEADER --}}
                <div class="zone-wrapper" id="header" data-zone="header">
                    <span class="zone-label"><i class="fa-solid fa-heading me-1"></i> Header Zone</span>
                    @include('admin.sections.item_renderer', ['items' => $sections['header'] ?? []])
                </div>

                {{-- ZONE HERO --}}
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

                {{-- ZONE FOOTER --}}
                <div class="zone-wrapper" id="footer" data-zone="footer">
                    <span class="zone-label"><i class="fa-solid fa-shoe-prints me-1"></i> Footer Zone</span>
                    @include('admin.sections.item_renderer', ['items' => $sections['footer'] ?? []])
                </div>
            </div>

            {{-- TAB 2: LIVE PREVIEW --}}
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
                    {{-- Loading Spinner --}}
                    <div id="preview-loader" class="loading-overlay">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    {{-- IFRAME KOSONG --}}
                    <iframe id="site-preview" src="" title="Website Preview"></iframe>
                </div>
            </div>

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
