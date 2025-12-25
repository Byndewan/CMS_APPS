<div class="section-wrapper" style="background-color: {{ $section->bg_color ?? 'transparent' }};">
    @if ($section->type == 'static')
        <div class="static-content py-3">
            {!! $section->static_content !!}
        </div>
    @elseif($section->type == 'dynamic' && isset($section->fetched_posts))
        <div class="dynamic-content py-3">
            <div class="d-flex align-items-center justify-content-center mb-4">
                <h3 class="fw-bold text-dark mb-0 position-relative" style="letter-spacing: -0.5px;">{{ $section->title }}
                    <span class="position-absolute start-0 bottom-0 bg-primary"
                        style="width: 40px; height: 3px; margin-bottom: -8px; border-radius: 2px;"></span>
                </h3>

                {{-- Tombol 'Lihat Semua' (Opsional, arahkan ke halaman modul kalau nanti ada) --}}
                {{-- <a href="#" class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-muted small">
                    Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i>
                </a> --}}
            </div>
            <div class="row g-4">
                @forelse($section->fetched_posts as $post)
                    <div class="col-md-4 d-flex align-items-stretch px-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden w-100 card-hover-effect">
                            @php
                                $thumb = null;
                                $content = $post->content ?? [];
                                if (is_array($content)) {
                                    foreach ($content as $val) {
                                        if (
                                            is_string($val) &&
                                            (str_contains($val, '.jpg') || str_contains($val, '.png'))
                                        ) {
                                            $thumb = asset('storage/' . $val);
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            <div class="position-relative overflow-hidden" style="height: 220px;">
                                @if ($thumb)
                                    <img src="{{ $thumb }}" class="w-100 h-100 object-fit-cover transition-scale"
                                        alt="{{ $post->title }}" loading="lazy">
                                @else
                                    <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-image text-muted fa-3x opacity-25"></i>
                                    </div>
                                @endif
                                <div class="position-absolute top-0 end-0 m-3 bg-white px-3 py-1 rounded-pill shadow-sm small fw-bold text-dark"
                                    style="font-size: 0.75rem;">
                                    {{ $post->created_at->format('d M') }}
                                </div>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <small class="text-primary fw-bold text-uppercase mb-2"
                                    style="font-size: 0.7rem; letter-spacing: 1px;">
                                    {{ $section->module->name ?? 'Article' }}
                                </small>
                                <h5 class="card-title fw-bold text-dark mb-3 lh-sm">
                                    <a href="{{ route('front.post.show', $post->slug) }}"
                                        class="text-decoration-none text-dark stretched-link">
                                        {{ Str::limit($post->title, 60) }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted small flex-grow-1 mb-4" style="line-height: 1.6;">
                                    @php
                                        $previewText = 'Klik untuk membaca selengkapnya...';
                                        foreach ($content as $val) {
                                            if (
                                                is_string($val) &&
                                                !str_contains($val, '.jpg') &&
                                                !str_contains($val, '.png') &&
                                                strlen($val) > 10
                                            ) {
                                                $previewText = Str::limit(strip_tags($val), 90);
                                                break;
                                            }
                                        }
                                    @endphp
                                    {{ $previewText }}
                                </p>
                                <div
                                    class="d-flex align-items-center justify-content-between pt-3 border-top border-light">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-muted"
                                            style="width: 28px; height: 28px;">
                                            <i class="fa-solid fa-user" style="font-size: 0.7rem;"></i>
                                        </div>
                                        <small class="text-muted fw-bold" style="font-size: 0.8rem;">Admin</small>
                                    </div>
                                    <small class="text-primary fw-bold" style="font-size: 0.8rem;">Baca <i
                                            class="fa-solid fa-arrow-right ms-1"></i></small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border-0 text-center py-5 rounded-4">
                            <i class="fa-solid fa-folder-open fa-3x text-muted opacity-25 mb-3"></i>
                            <p class="text-muted fw-bold">Belum ada konten di section ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>
<style>
    .card-hover-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .transition-scale {
        transition: transform 0.5s ease;
    }

    .card-hover-effect:hover .transition-scale {
        transform: scale(1.05);
    }
</style>
