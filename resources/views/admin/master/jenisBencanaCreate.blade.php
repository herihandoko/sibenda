@php
    $page_title = 'Admin | Jenis Bencana';
@endphp
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/mediamanager.css') }}">
@endpush
@extends('admin.layouts.master')
@section('content')
    {{-- Main Content --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Jenis Bencana</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{ route('admin.master.jenis-bencana.index') }}" role="button">
                <i class="fas fa-arrow-circle-left"></i> {{ trans('admin.Back') }}
            </a>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.master.jenis-bencana.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="icon" data-preview="icon" class="btn btn-primary"
                                            style="border-radius: 0rem !important; padding: 0.5rem 0.75rem !important; color:white !important;">
                                            <i class="fa fa-image"></i>Choose
                                        </a>
                                    </span>
                                    <input id="icon" class="form-control" type="text" name="icon">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" href="#" role="button">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('admin.layouts.mediaModal')
@endsection
@push('script')
    @include('admin.layouts.mediaJs')
    <script src="{{ asset('assets/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $('#lfm').filemanager('file');
    </script>
@endpush
