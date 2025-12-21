@extends('front.layouts.app')

@section('title', 'Home')

@section('content')

    {{-- HEADER --}}
    @if(isset($sections['header']))
        <div id="zone-header" class="w-100 border-bottom">
            @foreach($sections['header'] as $section)
                @include('front.sections.renderer', ['section' => $section])
            @endforeach
        </div>
    @endif

    {{-- HERO --}}
    @if(isset($sections['hero']))
        <div id="zone-hero" class="w-100">
            @foreach($sections['hero'] as $section)
                @include('front.sections.renderer', ['section' => $section])
            @endforeach
        </div>
    @endif

    {{-- CONTAINER UTAMA --}}
    <div class="container my-5">
        <div class="row">

            {{-- SIDEBAR LEFT --}}
            <div class="col-lg-3 order-2 order-lg-1 mb-4">
                @if(isset($sections['sidebar_left']))
                    <div id="zone-sidebar-left">
                        @foreach($sections['sidebar_left'] as $section)
                            @include('front.sections.renderer', ['section' => $section])
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- MAIN CONTENT --}}
            <div class="col-lg-6 order-1 order-lg-2 mb-4">

                {{-- Main Top --}}
                @if(isset($sections['main_top']))
                    <div id="zone-main-top" class="mb-4">
                        @foreach($sections['main_top'] as $section)
                            @include('front.sections.renderer', ['section' => $section])
                        @endforeach
                    </div>
                @endif

                {{-- Main Center --}}
                @if(isset($sections['main_center']))
                    <div id="zone-main-center" class="mb-4">
                        @foreach($sections['main_center'] as $section)
                            @include('front.sections.renderer', ['section' => $section])
                        @endforeach
                    </div>
                @endif

                {{-- Main Bottom --}}
                @if(isset($sections['main_bottom']))
                    <div id="zone-main-bottom" class="mb-4">
                        @foreach($sections['main_bottom'] as $section)
                            @include('front.sections.renderer', ['section' => $section])
                        @endforeach
                    </div>
                @endif

            </div>

            {{-- SIDEBAR RIGHT --}}
            <div class="col-lg-3 order-3 order-lg-3 mb-4">
                @if(isset($sections['sidebar_right']))
                    <div id="zone-sidebar-right">
                        @foreach($sections['sidebar_right'] as $section)
                            @include('front.sections.renderer', ['section' => $section])
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- FOOTER --}}
    @if(isset($sections['footer']))
        <div id="zone-footer" class="bg-light mt-auto">
            <div class="container">
                @foreach($sections['footer'] as $section)
                    @include('front.sections.renderer', ['section' => $section])
                @endforeach
            </div>
        </div>
    @endif

@endsection
