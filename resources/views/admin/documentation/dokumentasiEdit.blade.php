@php
    $page_title = 'Admin | Status Korban';
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
                <h1>Ubah Dokumentasi</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{ route('admin.documentation') }}" role="button">
                <i class="fas fa-arrow-circle-left"></i> {{ trans('admin.Back') }}
            </a>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.documentation.update',$dokumentasi->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="">Judul</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="title" required value="{{ $dokumentasi->title }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="">Tanggal</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="tanggal" required value="{{ $dokumentasi->tanggal }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="">Deskripsi</label>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control h-100" name="description" rows="3">{{ $dokumentasi->description }}</textarea>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12 form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Photo 1</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm_1" data-input="image_1" data-preview="holder_1"
                                                    class="btn btn-primary"
                                                    style="border-radius: 0rem !important; padding: 0.5rem 0.75rem !important; color:white !important;">
                                                    <i class="fa fa-image"></i> Choose
                                                </a>
                                            </span>
                                            <input id="image_1" class="form-control" type="text" name="image_1" value="{{ $dokumentasi->image_1 }}">
                                        </div>
                                        <img id="holder_1" style="margin-top:15px;max-height:100px;"><br>
                                        <label for="">Photo 2</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm_2" data-input="image_2" data-preview="holder_2"
                                                    class="btn btn-primary"
                                                    style="border-radius: 0rem !important; padding: 0.5rem 0.75rem !important; color:white !important;">
                                                    <i class="fa fa-image"></i> Choose
                                                </a>
                                            </span>
                                            <input id="image_2" class="form-control" type="text" name="image_2" value="{{ $dokumentasi->image_2 }}">
                                        </div>
                                        <img id="holder_2" style="margin-top:15px;max-height:100px;"><br>
                                        <label for="">Photo 3</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm_3" data-input="image_3" data-preview="holder_3"
                                                    class="btn btn-primary"
                                                    style="border-radius: 0rem !important; padding: 0.5rem 0.75rem !important; color:white !important;">
                                                    <i class="fa fa-image"></i> Choose
                                                </a>
                                            </span>
                                            <input id="image_3" class="form-control" type="text" name="image_3" value="{{ $dokumentasi->image_3 }}">
                                        </div>
                                        <img id="holder_3" style="margin-top:15px;max-height:100px;">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Photo 4</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm_4" data-input="image_4" data-preview="holder_4"
                                                    class="btn btn-primary"
                                                    style="border-radius: 0rem !important; padding: 0.5rem 0.75rem !important; color:white !important;">
                                                    <i class="fa fa-image"></i> Choose
                                                </a>
                                            </span>
                                            <input id="image_4" class="form-control" type="text" name="image_4" value="{{ $dokumentasi->image_4 }}">
                                        </div>
                                        <img id="holder_4" style="margin-top:15px;max-height:100px;"><br>
                                        <label for="">Photo 5</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm_5" data-input="image_5" data-preview="holder_5"
                                                    class="btn btn-primary"
                                                    style="border-radius: 0rem !important; padding: 0.5rem 0.75rem !important; color:white !important;">
                                                    <i class="fa fa-image"></i> Choose
                                                </a>
                                            </span>
                                            <input id="image_5" class="form-control" type="text" name="image_5" value="{{ $dokumentasi->image_5 }}">
                                        </div>
                                        <img id="holder_5" style="margin-top:15px;max-height:100px;"><br>
                                        <label for="">Photo 6</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm_6" data-input="image_6" data-preview="holder_6"
                                                    class="btn btn-primary"
                                                    style="border-radius: 0rem !important; padding: 0.5rem 0.75rem !important; color:white !important;">
                                                    <i class="fa fa-image"></i> Choose
                                                </a>
                                            </span>
                                            <input id="image_6" class="form-control" type="text" name="image_6" value="{{ $dokumentasi->image_6 }}">
                                        </div>
                                        <img id="holder_6" style="margin-top:15px;max-height:100px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block" href="#" role="button">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('admin.layouts.mediaModal')
@endsection
@push('script')
    <script src="{{ asset('assets/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    @include('admin.layouts.mediaJs')
    <script>
        $('#lfm_1').filemanager('file');
        $('#lfm_2').filemanager('file');
        $('#lfm_3').filemanager('file');
        $('#lfm_4').filemanager('file');
        $('#lfm_5').filemanager('file');
        $('#lfm_6').filemanager('file');
    </script>
@endpush
