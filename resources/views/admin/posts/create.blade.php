@extends('admin.layouts.app')

@section('title', 'Tambah ' . $module->name)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-1">Tambah {{ $module->name }}</h2>
            <a href="{{ route('admin.content.index', $module->slug) }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.content.store', $module->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- 1. JUDUL UTAMA --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul / Nama <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg"
                            placeholder="Contoh: Pembuatan Website / PT. Maju Mundur" required>
                        <small class="text-muted">Ini akan menjadi judul utama data ini.</small>
                    </div>

                    <hr class="my-4">
                    @foreach ($module->form_schema as $field)
                        <div class="mb-4">
                            <label class="form-label fw-bold">{{ $field['label'] }}</label>

                            {{-- TIPE TEXT --}}
                            @if ($field['type'] == 'text')
                                <input type="text" name="content[{{ $field['name'] }}]" class="form-control"
                                    placeholder="Masukkan {{ $field['label'] }}">

                                {{-- TIPE TEXTAREA --}}
                            @elseif($field['type'] == 'textarea')
                                <textarea name="content[{{ $field['name'] }}]" class="form-control" rows="4"></textarea>

                                {{-- TIPE FILE / GAMBAR --}}
                            @elseif($field['type'] == 'file')
                                <input type="file" name="content[{{ $field['name'] }}]" class="form-control">
                                <small class="text-muted">Format: JPG/PNG. Max 2MB.</small>
                            @endif

                        </div>
                    @endforeach
                    <div class="d-flex justify-content-end mt-5">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fa-solid fa-save me-2"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
