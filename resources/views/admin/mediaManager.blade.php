@php
$page_title = trans('admin.Admin | Media manager');
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
                <h1>{{trans('admin.Media manager')}}</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{route('admin.dashboard')}}" role="button"><i class="fas fa-arrow-circle-left    "></i> {{trans('admin.Back')}}</a>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        @if (Session::has('success'))
                            <div class="alert alert-success mb-4">
                                {{Session::get('success')}}
                            </div>
                        @endif
                        <!-- Modal -->
                        <div class="card">
                            <div >
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{trans('admin.Media manager')}}</h5>
                                        <!-- Actual search box -->
                                        <div class="form-group has-search">
                                            <span class="fa fa-search form-control-feedback"></span>
                                            <input name="search" id="search" type="text" class="form-control"
                                                placeholder="Search">
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-danger alert-dismissible fade d-none" role="alert"
                                            id="alert">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">{{trans('admin.Close')}}</span>
                                            </button>
                                            <strong>{{trans('admin.File Deleted!')}}</strong>
                                        </div>
                                        <div class="row" id="table_data">
                                        </div>
                                    </div>
                                    <div class="modal-footer d-block">
                                        <form id="formId" method="POST" enctype="multipart/form-data"
                                            action="<?= route('admin.mediaupload') ?>">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"
                                                        id="inputGroupFileAddon01">{{trans('admin.Upload')}}</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input name="image" type="file" class="custom-file-input"
                                                        id="inputGroupFile"
                                                        aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="inputGroupFile01">{{trans('admin.Choose File')}}</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name" id="file-name"
                                                    placeholder="Image Name">
                                            </div>
                                            <div class="progress mb-4" id="image-progress">
                                                <div class="progress-bar" role="progressbar" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-sm btn-primary float-left" type="submit"> <i
                                                        class="fas fa-upload    "></i> {{trans('admin.Upload')}}</button>
                                                <button id="delete_button" type="button"
                                                    class="btn btn-sm btn-danger float-right"><i
                                                        class="fas fa-trash    "></i> {{trans('admin.Delete')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    @include('admin.layouts.mediaJs')
@endpush
