@extends('frontend.page')
@section('title_prefix', 'Beranda - Dokumentasi')
@section('title', 'Beranda')
@section('content')
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Detail Dokumentasi</h2>
                <ol>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/dokumentasi') }}">Dokumentasi</a></li>
                    <li>Detail Dokumentasi</li>
                </ol>
            </div>

        </div>
    </section>
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-8">
                    <div
                        class="portfolio-details-slider swiper swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
                        <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                            @if ($dokumen->image_1)
                                <li data-thumb="{{ $dokumen->image_1 }}">
                                    <img src="{{ $dokumen->image_1 }}" width="100%" />
                                </li>
                                @if ($dokumen->image_2)
                                    <li data-thumb="{{ $dokumen->image_2 }}">
                                        <img src="{{ $dokumen->image_2 }}" width="100%" />
                                    </li>
                                @endif
                                @if ($dokumen->image_3)
                                    <li data-thumb="{{ $dokumen->image_3 }}">
                                        <img src="{{ $dokumen->image_3 }}" width="100%" />
                                    </li>
                                @endif
                                @if ($dokumen->image_4)
                                    <li data-thumb="{{ $dokumen->image_4 }}">
                                        <img src="{{ $dokumen->image_4 }}" width="100%" />
                                    </li>
                                @endif
                                @if ($dokumen->image_5)
                                    <li data-thumb="{{ $dokumen->image_5 }}">
                                        <img src="{{ $dokumen->image_5 }}" width="100%" />
                                    </li>
                                @endif
                                @if ($dokumen->image_6)
                                    <li data-thumb="{{ $dokumen->image_6 }}">
                                        <img src="{{ $dokumen->image_6 }}" width="100%" />
                                    </li>
                                @endif
                                @if ($dokumen->image_2)
                                    <li data-thumb="{{ $dokumen->image_2 }}">
                                        <img src="{{ $dokumen->image_2 }}" width="100%" />
                                    </li>
                                @endif
                            @else
                                <div class="text-center">
                                    <img src="{{ asset('assets/frontend/images/data-not-found.svg') }}" class="rounded"
                                        alt="Data not found" height="300">
                                    <div class="alert alert-info" role="alert">Tidak ada photo dokumentasi.</div>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="portfolio-info">
                        <h3>Informasi Dokumentasi</h3>
                        <ul>
                            <li><strong>Jenis Bencana</strong>: {{ $dokumen->jenis_bencana }}</li>
                            <li><strong>Tanggal</strong>:
                                {{ $carbon::createFromFormat('Y-m-d', $dokumen->tgl_kejadian)->format('d M Y') }}</li>
                            <li><strong>Jam
                                    Kejadian</strong>:{{ $carbon::createFromFormat('H:i:s', $dokumen->jam_kejadian)->format('H:i') }}
                            </li>
                            <li><strong>Kab/Kota</strong>:{{ $dokumen->nama_kota }}</li>
                            <li><strong>Kecamatan</strong>:{{ $dokumen->nama_kec }}</li>
                            <li><strong>Kelurahan</strong>:{{ $dokumen->nama_kel }}</li>
                            <li><strong>Penyebab</strong>:{{ $dokumen->penyebab_bencana }}</li>
                            <li><strong>Deskripsi</strong>:{{ $dokumen->deskripsi_bencana }}</li>
                        </ul>
                    </div>
                    <div class="portfolio-description">
                        <p>{!! $dokumen->deskripsi_bencana !!}</p>
                    </div>
                </div>

            </div>

        </div>
    </section>
@stop
@section('css')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/vendor/lightslider-master/src/css/lightslider.css') }}" />
@stop
@section('js')
    <script src="{{ asset('assets/vendor/lightslider-master/src/js/lightslider.js') }}"></script>
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
