@php
$page_title = 'Admin | Jenis Hunian';
@endphp
@push('style')
    <link rel="stylesheet" href="{{asset('assets/admin/css/mediamanager.css')}}">

@endpush
@extends('admin.layouts.master')
@section('content')
    {{-- Main Content --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Jenis Hunian</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{route('admin.master.jenis-hunian.index')}}" role="button">
                <i class="fas fa-arrow-circle-left"></i> {{trans('admin.Back')}}
            </a>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.master.jenis-hunian.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" name="name" required>
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
@endpush