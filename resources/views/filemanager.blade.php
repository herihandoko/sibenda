@php
    $page_title = trans('admin.Admin | Edit User');
@endphp
@extends('admin.layouts.master')
@section('content')
    {{-- Main Content --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ trans('admin.Edit User') }}</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{ route('admin.users.index') }}" role="button"><i
                    class="fas fa-arrow-circle-left    "></i> {{ trans('admin.Back') }}</a>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <iframe src="{{ url('admin/laravel-filemanager') }}"
                            style="width: 100%; height: 700px; overflow: hidden; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
