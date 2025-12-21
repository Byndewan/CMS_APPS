@foreach ($items as $section)
    <div class="card mb-2 shadow-sm border section-item" data-id="{{ $section->id }}">
        <div class="card-body p-3 d-flex justify-content-between align-items-center">

            {{-- Kolom Info --}}
            <div class="d-flex align-items-center gap-3">
                <div class="text-muted"><i class="fa-solid fa-grip-vertical"></i></div>
                <div>
                    <h6 class="mb-0 fw-bold">{{ $section->title }}</h6>
                    <small class="text-muted badge bg-light text-dark border">
                        {{ ucfirst($section->type) }}
                    </small>
                </div>
            </div>

            {{-- Tombol Edit --}}
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#editModal-{{ $section->id }}">
                <i class="fa-solid fa-pen"></i>
            </button>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div class="modal fade" id="editModal-{{ $section->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.sections.update', $section->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Section: {{ $section->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        {{-- CONFIG UMUM --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Judul Section</label>
                                <input type="text" name="title" class="form-control" value="{{ $section->title }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Warna Background (Hex)</label>
                                <input type="color" name="bg_color" class="form-control form-control-color w-100"
                                    value="{{ $section->bg_color ?? '#ffffff' }}">
                            </div>
                        </div>

                        <hr>

                        {{-- FORM STATIC --}}
                        @if ($section->type == 'static')
                            <div class="mb-3">
                                <label class="form-label">Konten HTML / Teks</label>
                                <textarea name="static_content" class="form-control" rows="6">{{ $section->static_content }}</textarea>
                                <small class="text-muted">Bisa isi HTML (div, h1, p) atau teks biasa.</small>
                            </div>

                            {{-- FORM DYNAMIC --}}
                        @else
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label">Ambil Data dari Modul:</label>
                                    <select name="module_id" class="form-select">
                                        @foreach ($modules as $mod)
                                            <option value="{{ $mod->id }}"
                                                {{ $section->module_id == $mod->id ? 'selected' : '' }}>
                                                {{ $mod->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jumlah Tampil</label>
                                    <input type="number" name="limit_post" class="form-control"
                                        value="{{ $section->limit_post }}">
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
