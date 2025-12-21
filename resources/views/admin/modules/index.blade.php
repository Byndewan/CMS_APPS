@extends('admin.layouts.app')

@section('title', 'Module Builder')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Module Builder</h2>
            <a href="{{ route('admin.modules.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i> Buat Modul Baru
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Nama Modul</th>
                            <th>Slug / URL</th>
                            <th>Jumlah Data</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modules as $module)
                            <tr>
                                <td class="px-4 fw-bold">
                                    <i class="{{ $module->icon }} me-2 text-muted"></i> {{ $module->name }}
                                </td>
                                <td>/{{ $module->slug }}</td>
                                <td>{{ $module->posts->count() }} Post</td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.modules.edit', $module->id) }}"
                                            class="btn btn-sm btn-light border text-primary">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus modul ini? Semua data post di dalamnya akan ikut terhapus!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border text-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
