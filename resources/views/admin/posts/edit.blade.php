@extends('admin.layouts.app')

@section('title', 'Edit ' . $module->name)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-1">Edit {{ $module->name }}</h2>
            <a href="{{ route('admin.content.index', $module->slug) }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.content.update', [$module->slug, $post->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- JUDUL --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul / Nama <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg"
                            value="{{ old('title', $post->title) }}" required>
                    </div>

                    <hr class="my-4">

                    {{-- DYNAMIC FIELDS --}}
                    @foreach ($module->form_schema as $field)
                        <div class="mb-4">
                            <label class="form-label fw-bold">{{ $field['label'] }}</label>
                            @php
                                $oldValue = $post->content[$field['name']] ?? '';
                            @endphp

                            @if ($field['type'] == 'text')
                                <input type="text" name="content[{{ $field['name'] }}]" class="form-control"
                                    value="{{ $oldValue }}">
                            @elseif($field['type'] == 'textarea')
                                <textarea name="content[{{ $field['name'] }}]" class="form-control" rows="4">{{ $oldValue }}</textarea>
                            @elseif($field['type'] == 'file')
                                @if ($oldValue)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $oldValue) }}" height="80"
                                            class="rounded border p-1">
                                        <div class="small text-muted">Gambar saat ini</div>
                                    </div>
                                @endif
                                <input type="file" name="content[{{ $field['name'] }}]" class="form-control">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                            @endif
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-end mt-5">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
