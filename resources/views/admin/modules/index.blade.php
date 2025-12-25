@extends('admin.layouts.app')

@section('title', 'Kelola Modul')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Modules</h3>
            <p class="text-muted small mb-0">Kelola jenis konten website kamu di sini.</p>
        </div>
        <a href="{{ route('admin.modules.create') }}" class="btn btn-primary px-4 py-2 rounded-3 fw-bold shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Buat Modul Baru
        </a>
    </div>
    <div class="card border-0">
        <div class="card-body p-0">
            <div class="table-responsive rounded-3">
                <table class="table table-hover align-middle mb-0" style="width: 100%;">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted text-uppercase small fw-bold" style="width: 50px;">#</th>
                            <th class="py-3 text-muted text-uppercase small fw-bold">Nama Modul</th>
                            <th class="py-3 text-muted text-uppercase small fw-bold">Icon Class</th>
                            <th class="py-3 text-muted text-uppercase small fw-bold">Slug / URL</th>
                            <th class="pe-4 py-3 text-end text-muted text-uppercase small fw-bold" style="width: 150px;">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modules as $index => $module)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="{{ $module->icon }} fa-lg"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $module->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <code class="bg-light px-2 py-1 rounded text-primary small">{{ $module->icon }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-light text-muted border fw-normal px-3 py-2">
                                        /{{ $module->slug }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.modules.edit', $module->id) }}"
                                            class="btn btn-sm btn-light border text-primary" data-bs-toggle="tooltip"
                                            title="Edit Modul">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-light border text-danger btn-delete"
                                                data-bs-toggle="tooltip" title="Hapus Modul">
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
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3"
                                            style="width: 80px; height: 80px;">
                                            <i class="fa-solid fa-box-open fa-2x text-muted opacity-50"></i>
                                        </div>
                                        <h5 class="fw-bold text-muted">Belum ada modul</h5>
                                        <p class="text-muted small mb-3">Mulai buat modul konten pertamamu sekarang.</p>
                                        <a href="{{ route('admin.modules.create') }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-plus me-1"></i> Buat Modul
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($modules->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">
                {{ $modules->links() }}
            </div>
        @endif
    </div>
@endsection
