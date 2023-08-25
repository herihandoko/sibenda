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
                <h1>Tambah Data Bencana</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{ route('admin.data.data-bencana.index') }}" role="button">
                <i class="fas fa-arrow-circle-left"></i> {{ trans('admin.Back') }}
            </a>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.data.data-bencana.store') }}" method="POST">
                            @csrf
                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Kode Bencana</label>
                                        <input type="text" class="form-control" name="kode"
                                            value="{{ old('kode') }}" autofocus readonly>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Jenis Bencana *</label>
                                        <select class="form-control sel" name="jenis_bencana_id" id="jenis_bencana_id"
                                            required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach (App\Models\Master\JenisBencana::where('is_deleted', 0)->get() as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Tgl Kejadian *</label>
                                        <input type="date" class="form-control" name="tgl_kejadian" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Waktu Kejadian *</label>
                                        <input type="time" class="form-control" name="jam_kejadian" required>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h6><span class="col-md-12">Lokasi Bencana</span></h6>&nbsp;<a id="btn-add-lokasi-bencana"
                                    class="btn btn-sm btn-outline-info" data-value="0"><i class="fa fa-plus-circle"></i>Add
                                    Lokasi</a>
                            </div>
                            <div class="col-md-12 col-lokasi-bencana">
                                <div class="row" style="height: 30px !important; margin-top: 10px;">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Provinsi <span style="color: red;">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Kabupaten/Kota <span style="color: red;">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Kecamatan <span style="color: red;">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Desa/Kelurahan <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Kp./Link/Alamat Detail <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="">Action</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-lokasi-bencana" id="row-lokasi-bencana-0">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            @php
                                                $provinces = new App\Http\Controllers\Admin\DependentDropdownController();
                                                $provinces = $provinces->provinces();
                                            @endphp
                                            <select class="form-control sel-provinsi" name="provinsi[0]" id="provinsi_0"
                                                required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                                @foreach ($provinces->where('code', 36) as $item)
                                                    <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="form-control sel-kabupaten" name="kabupaten[0]" id="kabupaten_0"
                                                required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="form-control sel-kecamatan" name="kecamatan[0]" id="kecamatan_0"
                                                required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="form-control sel-kelurahan" name="kelurahan[0]" id="kelurahan_0"
                                                required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="lokasi[0]" id="lokasi_0"
                                                    placeholder="Kp./Link." aria-label="Recipient's lat lng"
                                                    aria-describedby="basic-addon2" required>
                                                <input type="hidden" class="form-control" name="latlng[0]"
                                                    id="latlng_0" placeholder="LatLng" aria-label="Recipient's lat lng"
                                                    aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary btn-map-lat-lng"
                                                        type="button" value="0"><i class="fa fa-map"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <a class="btn btn-danger btn-action-delete" value="0"><span
                                                    class="text-white">Delete</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row" id="luas_tinggi" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Luas Genangan *</label>
                                        <input type="number" class="form-control" name="luas_genangan"
                                            placeholder="m2">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tinggi Genangan *</label>
                                        <input type="number" class="form-control" name="tinggi_genangan"
                                            placeholder="cm">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Kondisi Cuaca *</label>
                                        <input type="text" class="form-control" name="kondisi_cuaca" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Potensi Bencana Susulan *</label>
                                        <input type="text" class="form-control" name="potensi_susulan" required>
                                    </div>
                                </div> --}}

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Penyebab Bencana *</label>
                                        <input type="text" class="form-control" name="penyebab_bencana" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Deskripsi Bencana</label>
                                        <textarea class="form-control h-100" name="deskripsi_bencana" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            {{-- 
                            <div class="row">
                                <h6><span class="col-md-12">Fasilitas Umum Yang Masih Bisa Digunakan</span></h6>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Akses ke lokasi bencana *</label>
                                        <select class="form-control" name="akses_lokasi" id="akses_lokasi" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            <option value="Tersedia">Tersedia</option>
                                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Sarana Transportasi *</label>
                                        <input type="text" class="form-control" name="sarana_trans" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Jalur Komunikasi *</label>
                                        <select class="form-control" name="jalur_komunikasi_id" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach (App\Models\Master\JalurKomunikasi::where('is_deleted', 0)->get() as $jalurKomunikasi)
                                                <option value="{{ $jalurKomunikasi->id }}">{{ $jalurKomunikasi->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Keadaan Jaringan Listrik *</label>
                                        <select class="form-control" name="keadaan_listrik" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            <option value="Tersedia">Tersedia</option>
                                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Keadaan Jaringan Air/Air Bersih *</label>
                                        <select class="form-control" name="keadaan_air" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            <option value="Tersedia">Tersedia</option>
                                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Fasilitas Kesehatan *</label>
                                        <input type="text" class="form-control" name="faskes" required>
                                    </div>
                                </div>
                            </div> --}}
                            <hr>
                            <div class="row">
                                <h6><span class="col-md-12">Dokumentasi</span></h6>
                            </div>
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
                                            <input id="image_1" class="form-control" type="text" name="image_1">
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
                                            <input id="image_2" class="form-control" type="text" name="image_2">
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
                                            <input id="image_3" class="form-control" type="text" name="image_3">
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
                                            <input id="image_4" class="form-control" type="text" name="image_4">
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
                                            <input id="image_5" class="form-control" type="text" name="image_5">
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
                                            <input id="image_6" class="form-control" type="text" name="image_6">
                                        </div>
                                        <img id="holder_6" style="margin-top:15px;max-height:100px;">
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
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <input class="form-control controls mt-1 col-md-4 ml-1" id="pac-input" type="text"
                        placeholder="Ketik Lokasi Kejadian Bencana" />
                    <input type="hidden" id="hidden-latlng" value="">
                    <div id="map"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-action-pick"><i class="far fa-save"></i>
                        Simpan</button>
                    <button type="button" class="btn btn-danger btn-action-close" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <style>
        /** For maps */
        #map {
            height: 75vh;
            width: 100%;
        }

        #description {
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
        }

        #infowindow-content .title {
            font-weight: bold;
        }

        #infowindow-content {
            display: none;
        }

        #map #infowindow-content {
            display: inline;
        }

        .pac-card {
            background-color: #fff;
            border: 0;
            border-radius: 2px;
            box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
            margin: 10px;
            padding: 0 0.5em;
            font: 400 18px Roboto, Arial, sans-serif;
            overflow: hidden;
            font-family: Roboto;
            padding: 0;
        }

        .pac-container {
            background-color: #FFF;
            z-index: 20 !important;
            position: fixed;
            display: inline-block;
            float: left;
        }

        .modal {
            z-index: 20 !important;
        }

        .modal-backdrop {
            z-index: 10 !important;
        }

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

        .pac-controls label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
            height: 40px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }

        #target {
            width: 345px;
        }
    </style>
@stop
@push('script')
    @include('admin.layouts.mediaJs')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTb2js8Dp-x_0Lcos0Zj4vS6uDTvSDlN8&callback=initAutocomplete&libraries=places&v=weekly&channel=2"
        async></script>
    <script src="{{ asset('assets/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '.btn-map-lat-lng', function() {
                $('#ajaxModel').modal('show');
                $("#map").height("500px");
                $('#hidden-latlng').val($(this).val());
                $('#pac-input').val('');
            });
        });


        $('a#btn-add-lokasi-bencana').click(function(e) {
            e.preventDefault();
            var _row = $(this).data('value') + 1;
            $(this).data('value', _row);
            var _htmlRow = "";
            _htmlRow += '<div class="row row-lokasi-bencana" id="row-lokasi-bencana-' + _row + '">';

            _htmlRow += '<div class="col-md-2">';
            _htmlRow += '<div class="form-group">';
            _htmlRow += '<select class="form-control sel-provinsi" name="provinsi[' + _row + ']" id="provinsi_' +
                _row + '" required>';
            _htmlRow += '<option value="" disabled selected>-- Pilih --</option>';
            _htmlRow += '<option value="16">BANTEN</option>';
            _htmlRow += '</select>';
            _htmlRow += '</div>';
            _htmlRow += '</div>';

            _htmlRow += '<div class="col-md-2">';
            _htmlRow += '<div class="form-group">';
            _htmlRow += '<select class="form-control sel-kabupaten" name="kabupaten[' + _row + ']" id="kabupaten_' +
                _row + '" required>';
            _htmlRow += '<option value="" disabled selected>-- Pilih --</option>';
            _htmlRow += '</select>';
            _htmlRow += '</div>';
            _htmlRow += '</div>';

            _htmlRow += '<div class="col-md-2">';
            _htmlRow += '<div class="form-group">';
            _htmlRow += '<select class="form-control sel-kecamatan" name="kecamatan[' + _row + ']" id="kecamatan_' +
                _row + '" required>';
            _htmlRow += '<option value="" disabled selected>-- Pilih --</option>';
            _htmlRow += '</select>';
            _htmlRow += '</div>';
            _htmlRow += '</div>';

            _htmlRow += '<div class="col-md-2">';
            _htmlRow += '<div class="form-group">';
            _htmlRow += '<select class="form-control sel-kelurahan" name="kelurahan[' + _row + ']" id="kelurahan_' +
                _row + '" required>';
            _htmlRow += '<option value="" disabled selected>-- Pilih --</option>';
            _htmlRow += '</select>';
            _htmlRow += '</div>';
            _htmlRow += '</div>';

            _htmlRow += '<div class="col-md-3">';
            _htmlRow += '<div class="form-group">';
            _htmlRow += '<div class="input-group mb-3">';
            _htmlRow += '<input type="text" class="form-control" name="lokasi[' + _row + ']" id="lokasi_' + _row +
                '" placeholder="Lokasi" aria-label="Lokasi" aria-describedby="basic-addon2" required>';
            _htmlRow += '<input type="hidden" class="form-control" name="latlng[' + _row + ']" id="latlng_' + _row +
                '" placeholder="LatLng" aria-label="Recipients Lat Lng" aria-describedby="basic-addon2">';
            _htmlRow += '<div class="input-group-append">';
            _htmlRow += '<button class="btn btn-outline-secondary btn-map-lat-lng" type="button" value="' + _row +
                '"><i class="fa fa-map"></i></button>';
            _htmlRow += '</div>';
            _htmlRow += '</div>';

            _htmlRow += '</div>';
            _htmlRow += '</div>';
            _htmlRow += '<div class="col-md-1">';
            _htmlRow += '<div class="form-group">';
            _htmlRow += '<a class="btn btn-danger btn-action-delete" value="' + _row +
                '"><span class="text-white">Delete</span></a>';
            _htmlRow += '</div>';
            _htmlRow += '</div>';
            _htmlRow += '</div>';
            $('.col-lokasi-bencana').append(_htmlRow);

            $('.sel-provinsi').select2();
            $('.sel-provinsi').on('change', function() {
                var _idAttr = $(this).attr("id");
                var _id = _idAttr.split('_');
                var _row = _id[1];
                onChangeSelect('{{ route('admin.cities') }}', $(this).val(), 'kabupaten_' + _row);
            });
            $('.sel-kabupaten').select2();
            $('.sel-kabupaten').on('change', function() {
                var _idAttr = $(this).attr("id");
                var _id = _idAttr.split('_');
                var _row = _id[1];
                onChangeSelect('{{ route('admin.districts') }}', $(this).val(), 'kecamatan_' + _row);
            });
            $('.sel-kecamatan').select2();
            $('.sel-kecamatan').on('change', function() {
                var _idAttr = $(this).attr("id");
                var _id = _idAttr.split('_');
                var _row = _id[1];
                onChangeSelect('{{ route('admin.villages') }}', $(this).val(), 'kelurahan_' + _row);
            });
            $('.sel-kelurahan').select2();

            $('.btn-map-lat-lng').click(function(e) {
                e.preventDefault();
                var _row = $(this).attr('value');
            });
        });

        $(".sel").change(function() {
            var selValue = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.master.jenis-bencana.getName') }}",
                data: {
                    id: selValue
                },
                success: function(data, textStatus, jqXHR) {
                    if (data['name'] == 'Banjir') {
                        $("#luas_tinggi").show(900);
                        $("[name='luas_genangan']").attr("required", true);
                        $("[name='tinggi_genangan']").attr("required", true);
                    } else {
                        $("#luas_tinggi").hide(900);
                        $("[name='luas_genangan']").attr("required", false);
                        $("[name='tinggi_genangan']").attr("required", false);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        });

        function onChangeSelect(url, id, name) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    $('#' + name).empty();
                    $('#' + name).append('<option>-- Pilih --</option>');

                    $.each(data, function(key, value) {
                        $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
        $(function() {
            $('.sel-provinsi').on('change', function() {
                var _idAttr = $(this).attr("id");
                var _id = _idAttr.split('_');
                var _row = _id[1];
                onChangeSelect('{{ route('admin.cities') }}', $(this).val(), 'kabupaten_' + _row);
            });

            $('.sel-kabupaten').on('change', function() {
                var _idAttr = $(this).attr("id");
                var _id = _idAttr.split('_');
                var _row = _id[1];
                onChangeSelect('{{ route('admin.districts') }}', $(this).val(), 'kecamatan_' + _row);
            });

            $('.sel-kecamatan').on('change', function() {
                var _idAttr = $(this).attr("id");
                var _id = _idAttr.split('_');
                var _row = _id[1];
                onChangeSelect('{{ route('admin.villages') }}', $(this).val(), 'kelurahan_' + _row);
            });
        });

        $('#lfm_1').filemanager('file');
        $('#lfm_2').filemanager('file');
        $('#lfm_3').filemanager('file');
        $('#lfm_4').filemanager('file');
        $('#lfm_5').filemanager('file');
        $('#lfm_6').filemanager('file');

        $('body').on('click', 'a.btn-action-delete', function(e) {
            e.preventDefault();
            var _row = $(this).attr('value');
            $('#row-lokasi-bencana-' + _row).remove();
        });

        $('body').on('click', '.btn-action-close', function() {
            $('#ajaxModel').modal('hide');
        });

        $('body').on('click', '.btn-action-pick', function() {
            $('#ajaxModel').modal('hide');
        });

        function initAutocomplete() {
            const _center = new google.maps.LatLng(-6.364233, 106.272860);
            const map = new google.maps.Map(document.getElementById("map"), {
                center: _center,
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true,
                mapTypeControl: false,
                mapTypeId: "roadmap",
                scaleControl: false,
                zoomControl: true,
            });

            const input = document.getElementById("pac-input");
            var pacContainerInitialized = false;
            $('#pac-input').keypress(function() {
                if (!pacContainerInitialized) {
                    $('.pac-container').css('z-index', '9999');
                    pacContainerInitialized = true;
                }
            });

            const searchBox = new google.maps.places.SearchBox(input);

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            let markers = [];

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }

                markers.forEach((marker) => {
                    marker.setMap(null);
                });
                markers = [];
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        return;
                    }

                    const icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25),
                    };

                    markers.push(
                        new google.maps.Marker({
                            map,
                            title: place.name,
                            position: place.geometry.location,
                            label: {
                                fontFamily: "'Font Awesome 5 Free'",
                                text: '\uf1ad',
                                fontWeight: '500',
                                color: '#FFFFFF',
                            },
                        })
                    );

                    var _row = $('#hidden-latlng').val();
                    $('#latlng_' + _row).val(place.geometry.location.lat() + ',' + place.geometry.location
                        .lng());
                    $('#lokasi_' + _row).val(place.formatted_address);
                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        }
    </script>
@endpush
