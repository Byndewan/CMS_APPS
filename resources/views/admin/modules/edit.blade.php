@extends('admin.layouts.app')

@section('title', 'Edit Modul')

@section('content')
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('admin.modules.index') }}" class="text-decoration-none text-muted small mb-1 d-block">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Modules
                </a>
                <h3 class="fw-bold mb-0 text-dark">Edit Modul: {{ $module->name }}</h3>
            </div>
            <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-light border text-danger btn-delete shadow-sm">
                    <i class="fa-solid fa-trash me-2"></i> Hapus Modul Ini
                </button>
            </form>
        </div>

        <form action="{{ route('admin.modules.update', $module->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card border-0 h-100 position-sticky" style="top: 20px;">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                            <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-sliders me-2"></i>Konfigurasi Dasar
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Nama Modul</label>
                                <input type="text" name="name" class="form-control form-control-lg bg-light border-0"
                                    value="{{ $module->name }}" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Icon Class</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i
                                            class="{{ $module->icon }} small"></i></span>
                                    <input type="text" name="icon"
                                        class="form-control form-control-lg bg-light border-0" value="{{ $module->icon }}"
                                        required>
                                </div>
                            </div>
                            <div class="alert alert-warning border-0 small mb-4">
                                <div class="d-flex gap-2">
                                    <i class="fa-solid fa-triangle-exclamation mt-1"></i>
                                    <div>
                                        <strong>Hati-hati!</strong><br>
                                        Mengubah "Nama Variable" kolom dapat menyebabkan data konten lama tidak muncul
                                        (hilang koneksi).
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                                <i class="fa-solid fa-save me-2"></i> SIMPAN PERUBAHAN
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card border-0 min-vh-100">
                        <div
                            class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold text-dark mb-1"><i
                                        class="fa-solid fa-layer-group me-2 text-primary"></i>Desain Kolom Input</h6>
                                <p class="text-muted small mb-0">Atur struktur data untuk modul ini.</p>
                            </div>
                            <button type="button" class="btn btn-dark btn-sm rounded-pill px-3" onclick="addField()">
                                <i class="fa-solid fa-plus me-1"></i> Tambah Kolom
                            </button>
                        </div>

                        <div class="card-body bg-body-tertiary mt-3 rounded-bottom-4" id="fields-container"
                            style="min-height: 300px;">
                            <div id="empty-msg" class="text-center py-5" style="display: none;">
                                <div class="mb-3">
                                    <i class="fa-solid fa-clipboard-list fa-3x text-muted opacity-25"></i>
                                </div>
                                <h6 class="text-muted fw-bold">Belum ada kolom input</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script>
        let uniqueId = 0;
        const existingFields = @json($module->form_schema);
        document.addEventListener("DOMContentLoaded", function() {
            if (existingFields && existingFields.length > 0) {
                existingFields.forEach(field => {
                    addField(field.label, field.name, field.type);
                });
            } else {
                document.getElementById('empty-msg').style.display = 'block';
            }
        });

        function addField(label = '', name = '', type = 'text') {
            document.getElementById('empty-msg').style.display = 'none';
            const container = document.getElementById('fields-container');

            const html = `
            <div class="card mb-3 border border-light shadow-sm field-item animate__animated animate__fadeIn">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-primary-soft text-primary border border-primary-subtle rounded-pill row-number">
                            Kolom #...
                        </span>
                        <button type="button" class="btn btn-sm btn-icon btn-light text-danger hover-danger" onclick="removeField(this)">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="small text-muted fw-bold mb-1">Label Input</label>
                            <input type="text" name="fields[${uniqueId}][label]"
                                   class="form-control bg-light border-0"
                                   value="${label}"
                                   id="label-${uniqueId}"
                                   onkeyup="generateSlug(${uniqueId})"
                                   required>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted fw-bold mb-1">Nama Variable</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fa-solid fa-code small"></i></span>
                                <input type="text" name="fields[${uniqueId}][name]"
                                       class="form-control bg-light border-0 text-primary fw-bold"
                                       value="${name}"
                                       id="name-${uniqueId}"
                                       onkeyup="enforceSlug(this)"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted fw-bold mb-1">Tipe Data</label>
                            <select name="fields[${uniqueId}][type]" class="form-select bg-light border-0">
                                <option value="text" ${type == 'text' ? 'selected' : ''}>Text Input</option>
                                <option value="textarea" ${type == 'textarea' ? 'selected' : ''}>Text Area</option>
                                <option value="file" ${type == 'file' ? 'selected' : ''}>File Upload</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
            uniqueId++;
            updateRowNumbers();
        }

        function removeField(button) {
            button.closest('.field-item').remove();
            const container = document.getElementById('fields-container');
            if (container.querySelectorAll('.field-item').length === 0) {
                document.getElementById('empty-msg').style.display = 'block';
            }
            updateRowNumbers();
        }

        function updateRowNumbers() {
            const badges = document.querySelectorAll('.row-number');
            badges.forEach((badge, index) => {
                badge.textContent = `Kolom #${index + 1}`;
            });
        }

        function generateSlug(index) {
            const labelInput = document.getElementById(`label-${index}`);
            const nameInput = document.getElementById(`name-${index}`);
            if (labelInput && nameInput) {
                let slug = labelInput.value.toLowerCase().replace(/ /g, '_').replace(/[^\w-]+/g, '');
                nameInput.value = slug;
            }
        }

        function enforceSlug(inputElement) {
            let val = inputElement.value.toLowerCase();
            inputElement.value = val.replace(/ /g, '_').replace(/[^\w-]+/g, '');
        }
    </script>

    <style>
        .form-control:focus,
        .form-select:focus {
            background-color: #fff !important;
            border: 1px solid var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }

        .hover-danger:hover {
            background-color: #fee2e2 !important;
            color: #dc2626 !important;
        }

        .bg-primary-soft {
            background-color: #eff6ff;
        }
    </style>
@endsection
