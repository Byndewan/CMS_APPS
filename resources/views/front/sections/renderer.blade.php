<div class="section-item mb-4 {{ $section->bg_color ? 'p-4 rounded' : '' }}"
     style="{{ $section->bg_color ? 'background-color: '.$section->bg_color : '' }}">
    @if(!in_array($section->zone, ['header', 'hero', 'footer']) && $section->title)
        <h4 class="fw-bold mb-3 border-bottom pb-2">{{ $section->title }}</h4>
    @endif

    {{-- KONTEN STATIS --}}
    @if($section->type == 'static')
        <div class="content-static">
            {!! $section->static_content !!}
        </div>

    {{-- KONTEN DINAMIS --}}
    @elseif($section->type == 'dynamic' && $section->module)
        <div class="content-dynamic">
            <div class="row g-3">
                @foreach($section->module->posts->take($section->limit_post) as $post)
                    <div class="col-12">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="fw-bold text-primary mb-1">{{ $post->title }}</h6>
                                <p class="small text-muted mb-0">
                                    {{ Str::limit(strip_tags(json_encode($post->content)), 80) }}
                                </p>
                                <a href="#" class="btn btn-sm btn-link text-decoration-none p-0 mt-2">Baca selengkapnya &rarr;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($section->module->posts->count() == 0)
                <div class="alert alert-info small">Belum ada data di modul {{ $section->module->name }}</div>
            @endif
        </div>
    @endif

</div>
