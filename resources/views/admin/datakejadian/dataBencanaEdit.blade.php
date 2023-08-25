@php
    $page_title = 'Admin | Data Bencana';
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
                <h1>Ubah Laporan Kejadian</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{ route('admin.laporan-kejadian.index') }}" role="button">
                <i class="fas fa-arrow-circle-left"></i> {{ trans('admin.Back') }}
            </a>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['url' => route('admin.laporan-kejadian.update',$dataBencana->id), 'method' => 'post', 'class' => 'kontak-email-form', 'enctype' => 'multipart/form-data']) }}
                        <b style="color: grey; font-size:16px;">Kejadian Bencana <span style="color: red">*</span></b>
                        <div class="form-group row mt-3">
                            <label for="jenis_bencana" class="col-sm-2 col-form-label">Jenis Bencana <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                {{ $dataBencana->jenis_bencana }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_kejadian" class="col-sm-2 col-form-label">Tanggal Kejadian <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                {{ $dataBencana->tgl_kejadian }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="waktu_kejadian" class="col-sm-2 col-form-label">Waktu Kejadian <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-2">
                                {{ $dataBencana->waktu_kejadian }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="provinsi" class="col-sm-2 col-form-label">Provinsi <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                Banten
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten/Kota <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                {{ $dataBencana->nama_kota }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kecamatan" class="col-sm-2 col-form-label">Kecamatan <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                {{ $dataBencana->nama_kec }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kelurahan" class="col-sm-2 col-form-label">Kelurahan/Desa <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                {{ $dataBencana->nama_kel }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lokasi_kejadian" class="col-sm-2 col-form-label">Lokasi Kejadian <span
                                    class="text-danger">*</span>
                                <p style="color: red; font-size:10px;">Klik peta untuk isi lokasi</p>
                            </label>
                            <div class="col-sm-10">
                                {{ $dataBencana->lokasi_kejadian }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penyebab_bencana" class="col-sm-2 col-form-label">Penyebab Bencana <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                {{ $dataBencana->penyebab_bencana }}
                            </div>
                        </div>
                        <hr>
                        <b style="color: grey; font-size:16px;">Dampak Bencana</b>
                        <div class="form-group row mt-3">
                            <label for="dampak_bencana_rr" class="col-sm-2 col-form-label">Rusak Ringan (RR)</label>
                            <div class="col-sm-2">
                                {{ $dataBencana->dampak_bencana_rr }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dampak_bencana_rs" class="col-sm-2 col-form-label">Rusak Sedang (RS)</label>
                            <div class="col-sm-2">
                                {{ $dataBencana->dampak_bencana_rs }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dampak_bencana_rb" class="col-sm-2 col-form-label">Rusak Berat (RB)</label>
                            <div class="col-sm-2">
                                {{ $dataBencana->dampak_bencana_rb }}
                            </div>
                        </div>
                        <hr>
                        <b style="color: grey; font-size:16px;">Korban Jiwa</b>
                        <div class="form-group row mt-3">
                            <label for="korban_jiwa_md" class="col-sm-2 col-form-label">Meninggal Dunia (MD)</label>
                            <div class="col-sm-2">
                                {{ $dataBencana->korban_jiwa_md }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="korban_jiwa_lr" class="col-sm-2 col-form-label">Luka Ringan (LR)</label>
                            <div class="col-sm-2">
                                {{ $dataBencana->korban_jiwa_lr }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="korban_jiwa_lb" class="col-sm-2 col-form-label">Luka Berat (LB)</label>
                            <div class="col-sm-2">
                                {{ $dataBencana->korban_jiwa_lb }}
                            </div>
                        </div>
                        <hr>
                        <b style="color: grey; font-size:16px;">Pengungsi Jiwa/KK</b>
                        <div class="form-group row mt-3">
                            <label for="pengungsi_jiwa" class="col-sm-2 col-form-label">Jiwa</label>
                            <div class="col-sm-2">
                                {{ $dataBencana->pengungsi_jiwa }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pengungsi_kk" class="col-sm-2 col-form-label">KK</label>
                            <div class="col-sm-2">
                                {{ $dataBencana->pengungsi_kk }}
                            </div>
                        </div>
                        <hr>
                        <b style="color: grey; font-size:16px;">Informasi Pelapor/Instansi <span
                                style="color: red">*</span></b>
                        <div class="form-group row mt-3">
                            <label for="nama_pelapor" class="col-sm-2 col-form-label">Nama Pelapor <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {{ $dataBencana->nama_pelapor }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telp_pelapor" class="col-sm-2 col-form-label">No Telp Darurat <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                {{ $dataBencana->telp_pelapor }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_pelapor" class="col-sm-2 col-form-label">Email <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                {{ $dataBencana->email_pelapor }}
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="image" class="col-sm-2 col-form-label">File Gambar (max:2MB) <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <img src="{{ url($dataBencana->dokumentasi) }}">
                            </div>
                        </div>
                        <hr>
                        <b style="color: grey; font-size:16px;">Kondisi Umum / Kronologis</b>
                        <div class="form-group row mt-3">
                            <div class="col-sm-12">
                                {{ $dataBencana->kondisi_umum }}
                            </div>
                        </div>
                        <hr>
                        <b style="color: grey; font-size:16px;">Kegiatan/Assesment/Upaya Penanganan Darurat yang di
                            lakukan</b>
                        <div class="form-group row mt-3">
                            <div class="col-sm-12">
                                {{ $dataBencana->kegiatan }}
                            </div>
                        </div>
                        <hr>
                        <b style="color: grey; font-size:16px;">Kendala/Kebutuhan mendesask/Potensi Bencana Susulan</b>
                        <div class="form-group row mt-3">
                            <div class="col-sm-12">
                                {{ $dataBencana->kendala }}
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="jenis_bencana" class="col-sm-2 col-form-label">Status Bencana <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <select name="status" class="form-control">
                                    <option value="diterima">Diterima</option>
                                    <option value="diverifikasi">Diverifikasi</option>
                                    <option value="ditangani">Ditangani</option>
                                    <option value="selesei">Selesei</option>
                                </select>
                            </div>
                        </div>
                        <div class="my-3">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>
                        <div class="text-center"><button type="submit" class="btn btn-primary">Edit Status Laporan</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" id="hidden-latlng" value="">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.mediaModal')
@endsection
@push('script')
    @include('admin.layouts.mediaJs')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTb2js8Dp-x_0Lcos0Zj4vS6uDTvSDlN8&callback=initAutocomplete&libraries=places&v=weekly&channel=2"
        async></script>
    <script src="{{ asset('assets/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script type="text/javascript"></script>
@endpush
