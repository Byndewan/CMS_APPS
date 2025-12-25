@extends('admin.layouts.app')

@section('title', 'Kelola ' . $module->name)

@section('content')
    <div class="container-fluid px-0">

        {{-- HEADER & SEARCH --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-0 text-dark">
                    <i class="{{ $module->icon }} me-2 text-primary"></i>{{ $module->name }}
                </h3>
                <p class="text-muted small mb-0">Total ada <span class="fw-bold text-dark">{{ $posts->total() }}</span> konten dalam modul ini.</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.content.create', $module->slug) }}" class="btn btn-primary px-4 fw-bold shadow-sm d-flex align-items-center">
                    <i class="fa-solid fa-plus me-2"></i> Buat Baru
                </a>
            </div>
        </div>

        {{-- CARD TABEL --}}
        <div class="card border-0 shadow-none">
            <div class="card-body p-0">
                <div class="table-responsive rounded-3">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted text-uppercase small fw-bold" style="width: 50px;">#</th>
                                <th class="py-3 text-muted text-uppercase small fw-bold">Judul Konten</th>
                                <th class="py-3 text-muted text-uppercase small fw-bold">Info</th>
                                <th class="py-3 text-muted text-uppercase small fw-bold">Tanggal</th>
                                <th class="pe-4 py-3 text-end text-muted text-uppercase small fw-bold" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $index => $post)
                                <tr>
                                    <td class="ps-4 text-muted fw-bold">{{ $posts->firstItem() + $index }}</td>

                                    {{-- Judul & Thumbnail Logic --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            {{-- Cek apakah ada field tipe 'file' di konten ini --}}
                                            @php
                                                $thumb = null;
                                                foreach($post->content as $key => $val) {
                                                    if(is_string($val) && (str_contains($val, '.jpg') || str_contains($val, '.png'))) {
                                                        $thumb = asset('storage/' . $val);
                                                        break;
                                                    }
                                                }
                                            @endphp

                                            @if($thumb)
                                                <img src="{{ $thumb }}" alt="Img" class="rounded-3 object-fit-cover border" style="width: 45px; height: 45px;">
                                            @else
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted border" style="width: 45px; height: 45px;">
                                                    <i class="fa-solid fa-image opacity-50"></i>
                                                </div>
                                            @endif

                                            <div>
                                                <span class="d-block fw-bold text-dark text-truncate" style="max-width: 300px;">
                                                    {{ $post->title }}
                                                </span>
                                                <a href="#" class="text-decoration-none small text-primary">Lihat di Website <i class="fa-solid fa-arrow-up-right-from-square ms-1" style="font-size: 10px;"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="badge bg-light text-muted border fw-normal mb-1 w-auto align-self-start">
                                                <i class="fa-solid fa-user me-1"></i> Admin
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted small">
                                            <i class="fa-regular fa-calendar me-1"></i> {{ $post->created_at->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.content.edit', ['module_slug' => $module->slug, 'id' => $post->id]) }}"
                                               class="btn btn-sm btn-light border text-primary"
                                               data-bs-toggle="tooltip" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <form action="{{ route('admin.content.destroy', ['module_slug' => $module->slug, 'id' => $post->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-light border text-danger btn-delete"
                                                        data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                <i class="fa-solid fa-file-circle-plus fa-2x text-muted opacity-50"></i>
                                            </div>
                                            <h5 class="fw-bold text-muted">Belum ada konten</h5>
                                            <p class="text-muted small mb-3">Jadilah yang pertama menulis di modul ini.</p>
                                            <a href="{{ route('admin.content.create', $module->slug) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-plus me-1"></i> Tambah Data Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PAGINATION --}}
            @if($posts->hasPages())
                <div class="card-footer bg-white border-top-0 py-3">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
