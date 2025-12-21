@extends('admin.layouts.app')

@section('title', 'Edit Modul')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Edit Modul: {{ $module->name }}</h2>

        <form action="{{ route('admin.modules.update', $module->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- CONFIG UTAMA --}}
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white fw-bold">Konfigurasi Dasar</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Modul</label>
                                <input type="text" name="name" class="form-control" value="{{ $module->name }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Icon (FontAwesome)</label>
                                <input type="text" name="icon" class="form-control" value="{{ $module->icon }}"
                                    required>
                                <small class="text-muted"><a href="https://fontawesome.com/search?o=r&m=free"
                                        target="_blank">Cari Icon di sini</a></small>
                            </div>
                            <div class="alert alert-warning small">
                                <i class="fa-solid fa-exclamation-triangle me-1"></i>
                                Hati-hati mengubah <strong>Variable</strong> kolom. Data lama mungkin tidak akan muncul jika
                                nama variable diganti.
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        <i class="fa-solid fa-save me-2"></i> SIMPAN PERUBAHAN
                    </button>
                </div>

                {{-- BUILDER FIELDS --}}
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Desain Form Input</span>
                            <button type="button" class="btn btn-sm btn-dark" onclick="addField()">
                                <i class="fa-solid fa-plus me-1"></i> Tambah Kolom
                            </button>
                        </div>
                        <div class="card-body bg-light" id="fields-container">
                            {{-- Kolom akan dimuat disini --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let fieldIndex = 0;

        // DATA DARI DATABASE
        const existingFields = @json($module->form_schema);

        // FUNGSI RENDER SAAT LOAD
        document.addEventListener("DOMContentLoaded", function() {
            if (existingFields && existingFields.length > 0) {
                existingFields.forEach(field => {
                    addField(field.label, field.name, field.type);
                });
            } else {
                document.getElementById('fields-container').innerHTML =
                    '<p class="text-muted text-center py-5" id="empty-msg">Belum ada kolom input.</p>';
            }
        });

        // FUNGSI ADD FIELD
        function addField(label = '', name = '', type = 'text') {
            const emptyMsg = document.getElementById('empty-msg');
            if (emptyMsg) emptyMsg.style.display = 'none';

            const container = document.getElementById('fields-container');

            const html = `
            <div class="card mb-2 border-0 shadow-sm field-item">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-secondary">Kolom</span>
                        <button type="button" class="btn-close" onclick="this.closest('.field-item').remove()"></button>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="small text-muted mb-1">Label</label>
                            <input type="text" name="fields[${fieldIndex}][label]" class="form-control" value="${label}" id="label-${fieldIndex}" onkeyup="generateSlug(${fieldIndex})" required>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted mb-1">Variable</label>
                            <input type="text" name="fields[${fieldIndex}][name]" class="form-control bg-light" value="${name}" id="name-${fieldIndex}" onkeyup="enforceSlug(this)" required>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted mb-1">Tipe</label>
                            <select name="fields[${fieldIndex}][type]" class="form-select">
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
            fieldIndex++;
        }

        function generateSlug(index) {
            const labelInput = document.getElementById(`label-${index}`);
            const nameInput = document.getElementById(`name-${index}`);
            let slug = labelInput.value.toLowerCase().replace(/ /g, '_').replace(/[^\w-]+/g, '');
            nameInput.value = slug;
        }

        function enforceSlug(inputElement) {
            let val = inputElement.value.toLowerCase();
            inputElement.value = val.replace(/ /g, '_').replace(/[^\w-]+/g, '');
        }
    </script>
@endsection
