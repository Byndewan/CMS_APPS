@extends('admin.layouts.app')

@section('title', $module->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">{{ $module->name }}</h2>
            <p class="text-muted">Kelola data {{ strtolower($module->name) }} kamu di sini.</p>
        </div>
        <a href="{{ route('admin.content.create', $module->slug) }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i> Tambah {{ $module->name }}
        </a>
    </div>

    {{-- Tabel Data --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3" width="5%">No</th>
                            <th class="py-3">Judul / Nama</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Tanggal Dibuat</th>
                            <th class="px-4 py-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $index => $post)
                            <tr>
                                <td class="px-4">{{ $index + $posts->firstItem() }}</td>

                                <td>
                                    <div class="fw-bold">{{ $post->title }}</div>
                                    <small class="text-muted">
                                        {{-- Trik: Ambil salah satu data meta kalau ada --}}
                                        {{ Str::limit($post->meta_data['description'] ?? '', 50) }}
                                    </small>
                                </td>

                                <td>
                                    @if($post->is_published)
                                        <span class="badge bg-success-subtle text-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Draft</span>
                                    @endif
                                </td>

                                <td>{{ $post->created_at->format('d M Y') }}</td>

                                <td class="px-4 text-end">
                                    <a href="#" class="btn btn-sm btn-light border me-1"><i class="fa-solid fa-edit"></i></a>
                                    <button class="btn btn-sm btn-light border text-danger"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-50">
                                    <br>
                                    Belum ada data di modul <strong>{{ $module->name }}</strong>.
                                    <br>
                                    <a href="{{ route('admin.content.create', $module->slug) }}" class="text-decoration-none mt-2 d-inline-block">Buat data baru sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginasi --}}
        <div class="card-footer bg-white py-3">
            {{ $posts->links() }}
        </div>
    </div>

</div>
@endsection
