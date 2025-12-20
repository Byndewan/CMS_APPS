@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2 class="mb-4">Dashboard Overview</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Modul</h5>
                    <p class="card-text display-6">{{ $sidebar_modules->count() }}</p>
                </div>
            </div>
        </div>
        {{-- Bisa tambah card lain disini --}}
    </div>
@endsection
