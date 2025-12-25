@extends('admin.layouts.app')

@section('title', 'Tulis ' . $module->name . ' Baru')

@section('content')
    <div class="container-fluid px-0">

        {{-- HEADER NAVIGATION --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('admin.content.index', $module->slug) }}" class="text-decoration-none text-muted small mb-1 d-block">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke {{ $module->name }}
                </a>
                <h3 class="fw-bold mb-0 text-dark">Buat Konten Baru</h3>
            </div>
        </div>

        <form action="{{ route('admin.content.store', $module->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">

                {{-- KOLOM KIRI: MAIN FORM --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">

                            {{-- 1. JUDUL KONTEN (Wajib Ada di Semua Modul) --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Judul / Nama Konten</label>
                                <input type="text" name="title" class="form-control form-control-lg bg-light border-0"
                                    placeholder="Masukkan judul di sini..." required>
                            </div>

                            <hr class="my-4 border-light">

                            {{-- 2. DYNAMIC FIELDS (Looping dari JSON Schema) --}}
                            @if(is_array($module->form_schema) && count($module->form_schema) > 0)
                                @foreach($module->form_schema as $field)

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-muted small text-uppercase">{{ $field['label'] }}</label>

                                        {{-- TIPE: TEXT (Pendek) --}}
                                        @if($field['type'] == 'text')
                                            <input type="text"
                                                   name="content[{{ $field['name'] }}]"
                                                   class="form-control bg-light border-0"
                                                   placeholder="Tulis {{ strtolower($field['label']) }}...">

                                        {{-- TIPE: TEXTAREA (Panjang) --}}
                                        @elseif($field['type'] == 'textarea')
                                            <textarea name="content[{{ $field['name'] }}]"
                                                      class="form-control bg-light border-0"
                                                      rows="6"
                                                      placeholder="Tulis detailnya di sini..."></textarea>

                                        {{-- TIPE: FILE (Upload) --}}
                                        @elseif($field['type'] == 'file')
                                            <div class="input-group">
                                                <input type="file"
                                                       name="content[{{ $field['name'] }}]"
                                                       class="form-control bg-light border-0"
                                                       id="file-{{ $field['name'] }}">
                                                <label class="input-group-text bg-white border-0 text-muted" for="file-{{ $field['name'] }}">
                                                    <i class="fa-solid fa-cloud-arrow-up me-2"></i> Upload
                                                </label>
                                            </div>
                                            <div class="form-text small">Format: JPG, PNG, PDF. Maks 2MB.</div>
                                        @endif
                                    </div>

                                @endforeach
                            @else
                                <div class="alert alert-info border-0 d-flex align-items-center gap-3">
                                    <i class="fa-solid fa-circle-info fa-lg text-info"></i>
                                    <div>
                                        <strong>Modul ini belum punya kolom input khusus.</strong><br>
                                        Silakan edit modul ini di menu "Modules" untuk menambahkan kolom.
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: PUBLISH ACTION --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm position-sticky" style="top: 20px;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-paper-plane me-2 text-primary"></i>Publikasi</h6>

                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold">Status</label>
                                <select name="is_published" class="form-select bg-light border-0">
                                    <option value="1" selected>Tayang (Published)</option>
                                    <option value="0">Konsep (Draft)</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm mt-2">
                                <i class="fa-solid fa-save me-2"></i> SIMPAN KONTEN
                            </button>

                            <a href="{{ route('admin.content.index', $module->slug) }}" class="btn btn-light w-100 py-2 fw-bold text-muted border-0 mt-2">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- CSS Tambahan Biar Inputnya Ganteng --}}
    <style>
        .form-control:focus, .form-select:focus {
            background-color: #fff !important;
            border: 1px solid var(--primary) !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
        }

        /* Styling khusus buat Textarea biar enak ngetik */
        textarea.form-control {
            resize: vertical; /* Biar bisa ditarik atas bawah */
            min-height: 120px;
        }

        /* Styling buat File Input biar gak kaku */
        input[type="file"]::file-selector-button {
            display: none; /* Sembunyikan tombol default 'Choose File' yang jelek */
        }
    </style>
@endsection
