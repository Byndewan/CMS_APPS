@extends('admin.layouts.app')

@section('title', 'Edit ' . $module->name)

@section('content')
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('admin.content.index', $module->slug) }}"
                    class="text-decoration-none text-muted small mb-1 d-block">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke {{ $module->name }}
                </a>
                <h3 class="fw-bold mb-0 text-dark">Edit Konten</h3>
            </div>
            <form action="{{ route('admin.content.destroy', ['module_slug' => $module->slug, 'id' => $post->id]) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-light border text-danger btn-delete shadow-sm">
                    <i class="fa-solid fa-trash me-2"></i> Hapus Konten
                </button>
            </form>
        </div>
        <form action="{{ route('admin.content.update', ['module_slug' => $module->slug, 'id' => $post->id]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Judul / Nama
                                    Konten</label>
                                <input type="text" name="title" class="form-control form-control-lg bg-light border-0"
                                    value="{{ $post->title }}" required>
                            </div>
                            <hr class="my-4 border-light">
                            @if (is_array($module->form_schema) && count($module->form_schema) > 0)
                                @foreach ($module->form_schema as $field)
                                    @php
                                        $fieldKey = $field['name'];
                                        $oldValue = $post->content[$fieldKey] ?? '';
                                    @endphp
                                    <div class="mb-4">
                                        <label
                                            class="form-label fw-bold text-muted small text-uppercase">{{ $field['label'] }}</label>
                                        @if ($field['type'] == 'text')
                                            <input type="text" name="content[{{ $fieldKey }}]"
                                                class="form-control bg-light border-0" value="{{ $oldValue }}"
                                                placeholder="Tulis {{ strtolower($field['label']) }}...">
                                        @elseif($field['type'] == 'textarea')
                                            <textarea name="content[{{ $fieldKey }}]" class="form-control bg-light border-0" rows="6">{{ $oldValue }}</textarea>
                                        @elseif($field['type'] == 'file')
                                            @if ($oldValue)
                                                <div
                                                    class="mb-2 p-2 border rounded d-flex align-items-center gap-3 bg-white">
                                                    @if (str_contains($oldValue, '.jpg') || str_contains($oldValue, '.png'))
                                                        <img src="{{ asset('storage/' . $oldValue) }}" class="rounded"
                                                            style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <i class="fa-solid fa-file-lines fa-2x text-muted ps-2"></i>
                                                    @endif
                                                    <div class="small">
                                                        <span class="d-block text-muted">File saat ini:</span>
                                                        <a href="{{ asset('storage/' . $oldValue) }}" target="_blank"
                                                            class="text-decoration-none fw-bold text-primary">
                                                            Lihat File / Foto
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="input-group">
                                                <input type="file" name="content[{{ $fieldKey }}]"
                                                    class="form-control bg-light border-0" id="file-{{ $fieldKey }}">
                                                <label class="input-group-text bg-white border-0 text-muted"
                                                    for="file-{{ $fieldKey }}">
                                                    <i class="fa-solid fa-cloud-arrow-up me-2"></i> Ganti File
                                                </label>
                                            </div>
                                            <div class="form-text small">Biarkan kosong jika tidak ingin mengubah file.
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info border-0">
                                    Modul ini belum memiliki konfigurasi kolom.
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm position-sticky" style="top: 20px;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-3"><i
                                    class="fa-solid fa-paper-plane me-2 text-primary"></i>Publikasi</h6>
                            <div class="mb-3 p-2 bg-light rounded border border-light small text-muted">
                                <i class="fa-solid fa-clock me-1"></i> Terakhir diupdate:<br>
                                <strong>{{ $post->updated_at->diffForHumans() }}</strong>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold">Status</label>
                                <select name="is_published" class="form-select bg-light border-0">
                                    <option value="1" {{ $post->is_published == 1 ? 'selected' : '' }}>
                                        Tayang (Published)
                                    </option>
                                    <option value="0" {{ $post->is_published == 0 ? 'selected' : '' }}>
                                        Konsep (Draft)
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm mt-2">
                                <i class="fa-solid fa-save me-2"></i> SIMPAN PERUBAHAN
                            </button>
                            <a href="{{ route('admin.content.index', $module->slug) }}"
                                class="btn btn-light w-100 py-2 fw-bold text-muted border-0 mt-2">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <style>
        .form-control:focus,
        .form-select:focus {
            background-color: #fff !important;
            border: 1px solid var(--primary) !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        input[type="file"]::file-selector-button {
            display: none;
        }
    </style>
@endsection
