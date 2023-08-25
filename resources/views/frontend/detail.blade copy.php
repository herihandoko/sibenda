@extends('frontend.page')
@section('title_prefix', 'Beranda - Dokumentasi')
@section('title', 'Beranda')
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item current"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item current"><a href="{{ url('/dokumentasi') }}">Dokumentasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dokumentasi Sebagai Monumen dan Cerminan Anak-Cucu
                    Belajar Kebencanaan</li>
            </ol>
        </div>
        <div class="content-column-wrapper page-beritaDetail detail-page">
            <div class="container mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="center-content-wrapper detail-berita">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="colImgBig">
                                        <h1 class="title text-left">{{ $dokumen->title }}</h1>
                                        <div class="information-post">
                                            <p class="text-left"><span
                                                    class="post-date">{{ $carbon::createFromFormat('Y-m-d', $dokumen->tanggal)->format('d M Y') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-8" style="box-shadow: 0 0 30px rgba(214, 215, 216, 0.4); padding:10px;">
                                    <div class="colImgBig">
                                        <div class="block">
                                            <div class="item">
                                                <div class="clearfix">
                                                    <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                                                        <li data-thumb="{{ $dokumen->image_1 }}">
                                                            <img src="{{ $dokumen->image_1 }}" width="100%"/>
                                                        </li>
                                                        @if ($dokumen->image_2)
                                                            <li data-thumb="{{ $dokumen->image_2 }}">
                                                                <img src="{{ $dokumen->image_2 }}" width="100%"/>
                                                            </li>
                                                        @endif
                                                        @if ($dokumen->image_3)
                                                            <li data-thumb="{{ $dokumen->image_3 }}">
                                                                <img src="{{ $dokumen->image_3 }}" width="100%"/>
                                                            </li>
                                                        @endif
                                                        @if ($dokumen->image_4)
                                                            <li data-thumb="{{ $dokumen->image_4 }}">
                                                                <img src="{{ $dokumen->image_4 }}" width="100%"/>
                                                            </li>
                                                        @endif
                                                        @if ($dokumen->image_5)
                                                            <li data-thumb="{{ $dokumen->image_5 }}">
                                                                <img src="{{ $dokumen->image_5 }}" width="100%"/>
                                                            </li>
                                                        @endif
                                                        @if ($dokumen->image_6)
                                                            <li data-thumb="{{ $dokumen->image_6 }}">
                                                                <img src="{{ $dokumen->image_6 }}" width="100%"/>
                                                            </li>
                                                        @endif
                                                        @if ($dokumen->image_2)
                                                            <li data-thumb="{{ $dokumen->image_2 }}">
                                                                <img src="{{ $dokumen->image_2 }}" width="100%"/>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <br>
                                            <p style="margin-top: 20px;">
                                                {!! $dokumen->description !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="sidebar">
                                        <h5>Dokumentasi Lainnya</h5>
                                        <hr>
                                        @if ($dokumentasi->count() > 0)
                                            <div class="row">
                                                @foreach ($dokumentasi as $key => $item)
                                                    <div class="col-md-12 mb-2">
                                                        <div class="card border-0"
                                                            style="padding-right:0px !important; padding-left:0px !important; ">
                                                            <img src="{{ $item->image_1 }}" class="card-img-top" width="100%" height="200">
                                                            <div class="card-body">
                                                                <h5 class="card-title"><a
                                                                        href="{{ url('dokumentasi') }}/{{ $item->slug }}">{{ $item->title }}</a>
                                                                </h5>
                                                                <div class="publikasi" style="font-size: 10px; color:grey;">
                                                                    <i class="fa fa-calendar"></i>
                                                                    {{ $carbon::createFromFormat('Y-m-d', $item->tanggal)->format('d M Y') }}
                                                                    &nbsp;&nbsp;<i class="fa fa-user"></i> Admin
                                                                </div>
                                                                @if ($item->description)
                                                                <p class="card-text">{!! $str::limit(strip_tags($item->description), 150, $end = '') !!} <a
                                                                        href="{{ url('dokumentasi') }}/{{ $item->slug }}">[...]</a>
                                                                </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <img src="{{ asset('assets/frontend/images/data-not-found.svg') }}"
                                                    class="rounded" alt="Data not found">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('vendor/lightslider-master/src/css/lightslider.css') }}" />
@stop
@section('js')
    <script src="{{ asset('vendor/lightslider-master/src/js/lightslider.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#content-slider").lightSlider({
                loop: true,
                keyPress: true
            });
            $('#image-gallery').lightSlider({
                gallery: true,
                item: 1,
                thumbItem: 9,
                slideMargin: 0,
                speed: 500,
                auto: true,
                loop: true,
                onSliderLoad: function() {
                    $('#image-gallery').removeClass('cS-hidden');
                }
            });
        });
    </script>
@stop
