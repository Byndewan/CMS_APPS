@extends('admin.layouts.app')

@section('title', 'Buat Modul Baru')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Desain Modul Baru</h2>

        <form action="{{ route('admin.modules.store') }}" method="POST">
            @csrf

            <div class="row">
                {{-- CONFIG UTAMA --}}
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white fw-bold">Konfigurasi Dasar</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Modul</label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Artikel Blog"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Icon (FontAwesome)</label>
                                <input type="text" name="icon" class="form-control"
                                    placeholder="fa-solid fa-newspaper" required>
                                <small class="text-muted"><a href="https://fontawesome.com/search?o=r&m=free"
                                        target="_blank">Cari Icon di sini</a></small>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
                        <i class="fa-solid fa-save me-2"></i> SIMPAN MODUL
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
                            <p class="text-muted text-center py-5" id="empty-msg">Belum ada kolom input. Klik tombol "Tambah
                                Kolom".</p>
                            {{-- Kolom akan muncul di sini --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- JAVASCRIPT BUAT NAMBAH ROW --}}
    <script>
        let fieldIndex = 0;

        function addField() {
            document.getElementById('empty-msg').style.display = 'none';
            const container = document.getElementById('fields-container');
            const html = `
            <div class="card mb-2 border-0 shadow-sm field-item">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-secondary">Kolom #${fieldIndex + 1}</span>
                        <button type="button" class="btn-close" onclick="this.closest('.field-item').remove()"></button>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="small text-muted mb-1">Label (Contoh: Judul Artikel)</label>
                            <input type="text"
                                   name="fields[${fieldIndex}][label]"
                                   class="form-control"
                                   placeholder="Masukkan Label..."
                                   id="label-${fieldIndex}"
                                   onkeyup="generateSlug(${fieldIndex})"
                                   required>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted mb-1">Variable (Otomatis/Bisa Di Edit)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-code"></i></span>
                                <input type="text"
                                       name="fields[${fieldIndex}][name]"
                                       class="form-control bg-light"
                                       placeholder="judul_artikel"
                                       id="name-${fieldIndex}"
                                       onkeyup="enforceSlug(this)"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted mb-1">Tipe Input</label>
                            <select name="fields[${fieldIndex}][type]" class="form-select">
                                <option value="text">Text Input</option>
                                <option value="textarea">Text Area</option>
                                <option value="file">File Upload</option>
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
