@php
$page_title = 'Admin | Lokasi Pengungsian';
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
                <h1>Ubah Lokasi Pengungsian</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{route('admin.data.lokasi-pengungsian.index')}}" role="button">
                <i class="fas fa-arrow-circle-left"></i> {{trans('admin.Back')}}
            </a>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.data.lokasi-pengungsian.update', $lokasiPengungsian->id)}}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Kode Bencana *</label>
                                        <select class="form-control" name="id_databencana" id="id_databencana" required autofocus>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach (App\Models\DataBencana\DataBencana::where('is_deleted', 0)->get() as $dataBencana)
                                                <option @if ($dataBencana->id == $lokasiPengungsian->id_databencana) selected @endif value="{{$dataBencana->id}}">{{$dataBencana->kode}} - {{ $dataBencana->jenisBencanas->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Kode Lokasi</label>
                                        <input type="text" class="form-control" name="kode" value="{{ $lokasiPengungsian->kode }}" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Jenis Hunian *</label>
                                        <select class="form-control sel" name="jenis_hunian_id" id="jenis_hunian_id" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach (App\Models\Master\JenisHunian::where('is_deleted', 0)->get() as $jenisHunian)
                                                <option @if ($jenisHunian->id == $lokasiPengungsian->jenis_hunian_id) selected @endif value="{{$jenisHunian->id}}">{{$jenisHunian->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                         <label for="">Kapasitas *</label>
                                         <input type="number" class="form-control" name="kapasitas" value="{{ $lokasiPengungsian->kapasitas }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                         <label for="">Alamat *</label>
                                         <textarea class="form-control h-100" name="alamat" rows="3" required>{{ $lokasiPengungsian->alamat }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Provinsi *</label>
                                        @php
                                            $provinces = new App\Http\Controllers\Admin\DependentDropdownController;
                                            $provinces = $provinces->provinces();
                                        @endphp
                                        <select class="form-control" name="provinsi" id="provinsi" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach ($provinces as $item)
                                                <option @if($lokasiPengungsian->provinsi == $item->id) selected @endif value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Kabupaten/Kota *</label>
                                        @php
                                            $cities = new App\Http\Controllers\Admin\DependentDropdownController;
                                            $cities = $cities->getCities();
                                        @endphp
                                        <select class="form-control" name="kabupaten" id="kabupaten" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach ($cities as $item)
                                                <option @if($lokasiPengungsian->kabupaten == $item->id) selected @endif value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Kecamatan *</label>
                                        @php
                                            $districts = new App\Http\Controllers\Admin\DependentDropdownController;
                                            $districts = $districts->getDistricts();
                                        @endphp
                                        <select class="form-control" name="kecamatan" id="kecamatan" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach ($districts as $item)
                                                <option @if($lokasiPengungsian->kecamatan == $item->id) selected @endif value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Desa/Kelurahan *</label>
                                        @php
                                            $villages = new App\Http\Controllers\Admin\DependentDropdownController;
                                            $villages = $villages->getVillages();
                                        @endphp
                                        <select class="form-control" name="kelurahan" id="kelurahan" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach ($villages as $item)
                                                <option @if($lokasiPengungsian->kelurahan == $item->id) selected @endif value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">RT</label>
                                        <input type="number" name="rt" class="form-control" value="{{ $lokasiPengungsian->rt }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">RW</label>
                                        <input type="number" name="rw" class="form-control" value="{{ $lokasiPengungsian->rw }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                         <label for="">Keterangan</label>
                                         <textarea class="form-control h-100" name="keterangan" rows="3">{{ $lokasiPengungsian->keterangan }}</textarea>
                                    </div>
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
    
    <script>
        function onChangeSelect(url, id, name) {
            // send ajax request to get the cities of the selected province and append to the select tag
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id
                },
                success: function (data) {
                    $('#' + name).empty();
                    $('#' + name).append('<option>-- Pilih --</option>');

                    $.each(data, function (key, value) {
                        $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
        $(function () {
            $('#provinsi').on('change', function () {
                onChangeSelect('{{ route("admin.cities") }}', $(this).val(), 'kabupaten');
            });
            
            $('#kabupaten').on('change', function () {
                onChangeSelect('{{ route("admin.districts") }}', $(this).val(), 'kecamatan');
            });
            
            $('#kecamatan').on('change', function () {
                onChangeSelect('{{ route("admin.villages") }}', $(this).val(), 'kelurahan');
            });
        });
    </script>
@endpush