@extends('frontend.page')
@section('title_prefix', 'Beranda - Dokumentasi')
@section('title', 'Beranda')
@section('content')
    <section style="padding-left:20px !important; padding-right:20px !important; padding-top:0px !important;">
        <div class="container">
            <div class="section-title">
                <h3>Dokumentasi</h3>
                <p>Dokumentasi Badan Penanggulangan Bencana Daerah Provinsi Banten</p>
            </div>
        </div>
        @if ($dokumentasi->count() > 0)
            <div class="row" >
                @foreach ($dokumentasi as $key => $item)
                    <div class="col-md-3 mb-2" style="box-shadow: 0 0 30px rgba(214, 215, 216, 0.4); padding:10px;">
                        <div class="card border-0" style="padding-right:0px !important; padding-left:0px !important; ">
                            <img src="{{ $item->image_1 }}" class="card-img-top" width="100%" height="200">
                            {{-- <img src="{{ $item->image_1 }}" class="attachment-featured size-featured wp-post-image" width="388" height="220" loading="lazy"> --}}
                            <div class="card-body">
                                <h5 class="card-title"><a
                                        href="{{ url('dokumentasi') }}/{{ $item->slug }}">{{ $item->title }}</a></h5>
                                <div class="publikasi" style="font-size: 10px; color:grey;"><i class="fa fa-calendar"></i>
                                    {{ $carbon::createFromFormat('Y-m-d', $item->tanggal)->format('d M Y') }} &nbsp;&nbsp;<i
                                        class="fa fa-user"></i> Admin</div>
                                @if ($item->description)
                                    <p class="card-text">{!! $str::limit(strip_tags($item->description), 150, $end = '') !!} <a href="{{ url('dokumentasi') }}/{{ $item->slug }}">[...]</a></p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <img src="{{ asset('assets/frontend/images/data-not-found.svg') }}" class="rounded" alt="Data not found">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="alert alert-info" role="alert">
                            Tidak ada data yang tersedia dalam dokumentasi
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        @endif
    </section>
@stop
@section('css')
@stop
@section('js')
    <script></script>
@stop
