@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Pengaturan Website</h2>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                {{-- KOLOM KIRI --}}
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-primary"><i class="fa-solid fa-id-card me-2"></i> Identitas Web</h5>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Website</label>
                                <input type="text" name="app_name" class="form-control"
                                    value="{{ get_setting('app_name') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Logo Website</label>
                                @if (get_setting('app_logo'))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . get_setting('app_logo')) }}" alt="Current Logo"
                                            height="50" class="border p-1 rounded">
                                    </div>
                                @endif
                                <input type="file" name="app_logo" class="form-control">
                                <small class="text-muted">Format: PNG, JPG (Max 2MB). Transparan lebih bagus.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Favicon (Icon Tab)</label>
                                @if (get_setting('app_favicon'))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . get_setting('app_favicon')) }}" alt="Favicon"
                                            height="50" class="border p-1 rounded">
                                    </div>
                                @endif
                                <input type="file" name="app_favicon" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi Footer</label>
                                <textarea name="app_description" class="form-control" rows="3">{{ get_setting('app_description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Teks Copyright</label>
                                <input type="text" name="footer_text" class="form-control"
                                    value="{{ get_setting('footer_text') }}">
                            </div>

                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-success"><i class="fa-solid fa-paint-brush me-2"></i> Tampilan</h5>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Warna Utama (Primary Color)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" id="colorInput"
                                        name="theme_color" value="{{ get_setting('theme_color') }}"
                                        title="Choose your color">
                                    <input type="text" class="form-control" id="colorText"
                                        value="{{ get_setting('theme_color') }}" readonly>
                                </div>
                                <small class="text-muted">Warna ini akan mengubah tombol dan header.</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

    {{-- Script --}}
    <script>
        document.getElementById('colorInput').addEventListener('input', function() {
            document.getElementById('colorText').value = this.value;
        });
    </script>
@endsection
