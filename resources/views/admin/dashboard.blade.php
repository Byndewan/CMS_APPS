@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold mb-0">Overview</h3>
        <p class="text-muted small">Selamat datang kembali, {{ Auth::guard('web')->user()->name ?? 'Admin' }}!</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100 border-0">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-primary-soft text-primary rounded-3 d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-box-open fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total
                            Modul</h6>
                        <h3 class="fw-bold mb-0">{{ $totalModules }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-file-lines fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total
                            Postingan</h6>
                        <h3 class="fw-bold mb-0">{{ $totalPosts }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-layer-group fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Page
                            Sections</h6>
                        <h3 class="fw-bold mb-0">{{ $totalSections }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="fa-solid fa-clock-rotate-left me-2 text-muted"></i>Baru
                        Ditambahkan</span>
                    <a href="{{ route('admin.modules.index') }}" class="btn btn-sm btn-light border text-muted"
                        style="font-size: 0.8rem;">Lihat Semua Modul</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 text-muted text-uppercase small py-3" style="width: 40%">Judul</th>
                                    <th class="text-muted text-uppercase small py-3">Modul</th>
                                    <th class="text-muted text-uppercase small py-3">Tanggal</th>
                                    <th class="text-end pe-4 text-muted text-uppercase small py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestPosts as $post)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $post->title }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border fw-normal">
                                                <i
                                                    class="{{ $post->module->icon ?? 'fa-solid fa-folder' }} me-1 text-muted"></i>
                                                {{ $post->module->name ?? 'Unknown' }}
                                            </span>
                                        </td>
                                        <td class="text-muted">{{ $post->created_at->format('d M Y') }}</td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('admin.content.edit', ['module_slug' => $post->module->slug, 'id' => $post->id]) }}"
                                                class="btn btn-sm btn-icon btn-light text-primary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png"
                                                alt="Empty" style="width: 60px; opacity: 0.5;"
                                                class="mb-3 d-block mx-auto">
                                            Belum ada postingan apapun.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-transparent fw-bold">
                    <i class="fa-solid fa-bolt me-2 text-warning"></i> Quick Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.modules.create') }}"
                            class="btn btn-light border text-start p-3 d-flex align-items-center gap-3 hover-shadow">
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center"
                                style="width: 35px; height: 35px;">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <div>
                                <span class="d-block fw-bold text-dark">Buat Modul Baru</span>
                                <span class="d-block small text-muted">Tambah jenis konten baru</span>
                            </div>
                        </a>

                        <a href="{{ route('admin.sections.index') }}"
                            class="btn btn-light border text-start p-3 d-flex align-items-center gap-3 hover-shadow">
                            <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center"
                                style="width: 35px; height: 35px;">
                                <i class="fa-solid fa-paintbrush"></i>
                            </div>
                            <div>
                                <span class="d-block fw-bold text-dark">Atur Tampilan Depan</span>
                                <span class="d-block small text-muted">Drag & Drop Layout</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card bg-primary text-white border-0"
                style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <div class="card-body text-center py-4">
                    <i class="fa-solid fa-rocket fa-2x mb-3 text-white-50"></i>
                    <h5 class="fw-bold">CMS Ready!</h5>
                    <p class="small text-white-50 mb-0">Semua sistem berjalan normal. Siap untuk mengelola konten hari ini.
                    </p>
                </div>
            </div>

        </div>
    </div>
@endsection
