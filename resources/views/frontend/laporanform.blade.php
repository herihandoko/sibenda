@extends('frontend.page')
@section('title_prefix', 'Form Laporan')
@section('title', 'Sibenda')
@section('content')
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Formulir Laporan Kejadian</h2>
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('laporankejadian') }}">Laporan Kejadian</a></li>
                    <li>Formulir Laporan Kejadian</li>
                </ol>
            </div>

        </div>
    </section>
    <section id="contact" class="contact" style="padding:10px 0px !important;">
        <div class="container aos-init aos-animate" data-aos="fade-up">

            <div class="section-title">
                <h2>Formulir</h2>
                <h3><span>Formulir Laporan Kejadian Bencana</span></h3>
                <p>Laporan Kejadian Bencana Daerah Provinsi Banten</p>
            </div>

            <div class="row aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-12">
                    {{ Form::open(['url' => route('laporankejadian.kirim'), 'method' => 'post', 'class' => 'kontak-email-form', 'enctype' => 'multipart/form-data']) }}
                    <b style="color: grey; font-size:16px;">Kejadian Bencana <span style="color: red">*</span></b>
                    <div class="form-group row mt-3">
                        <label for="jenis_bencana" class="col-sm-2 col-form-label">Jenis Bencana <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="jenis_bencana" id="jenis_bencana"
                                placeholder="Jenis Bencana" value="{{ old('jenis_bencana') }}">
                            <span style="color:red !important;">{{ $errors->first('jenis_bencana') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_kejadian" class="col-sm-2 col-form-label">Tanggal Kejadian <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="tgl_kejadian" id="tgl_kejadian"
                                value="{{ old('tgl_kejadian') }}">
                            <span style="color:red !important;">{{ $errors->first('tgl_kejadian') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="waktu_kejadian" class="col-sm-2 col-form-label">Waktu Kejadian <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-2">
                            <input type="time" class="form-control" name="waktu_kejadian" id="waktu_kejadian"
                                value="{{ old('waktu_kejadian') }}">
                            <span style="color:red !important;">{{ $errors->first('waktu_kejadian') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="provinsi" class="col-sm-2 col-form-label">Provinsi <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control sel-provinsi" name="provinsi" id="provinsi">
                                <option value="" disabled selected>-- Pilih --</option>
                                @foreach ($provinces->where('code', 36) as $item)
                                    <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                @endforeach
                            </select>
                            <span style="color:red !important;">{{ $errors->first('provinsi') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten/Kota <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control sel-kabupaten" name="kabupaten" id="kabupaten">
                                <option value="">Pilih Kabupaten Kota</option>
                            </select>
                            <span style="color:red !important;">{{ $errors->first('kabupaten') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kecamatan" class="col-sm-2 col-form-label">Kecamatan <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control sel-kecamatan" name="kecamatan" id="kecamatan">
                                <option value="">Pilih Kecamatan Kecamatan</option>
                            </select>
                            <span style="color:red !important;">{{ $errors->first('kecamatan') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kelurahan" class="col-sm-2 col-form-label">Kelurahan/Desa <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control sel-kelurahan" name="kelurahan" id="kelurahan">
                                <option value="">Pilih Kelurahan Kelurahan</option>
                            </select>
                            <span style="color:red !important;">{{ $errors->first('kelurahan') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lokasi_kejadian" class="col-sm-2 col-form-label">Lokasi Kejadian <span
                                class="text-danger">*</span>
                            <p style="color: red; font-size:10px;">Klik peta untuk isi lokasi</p>
                        </label>
                        <div class="col-sm-10">
                            <div class="input-group mb-2">
                                <input type="text" id="lokasi_kejadian" name="lokasi_kejadian" class="form-control"
                                    placeholder="" aria-label="lokasi_kejadian"
                                    aria-describedby="button-lokasi_kejadian">
                                <button class="btn btn-outline-secondary" type="button" id="button-lokasi_kejadian">
                                    <i class="fa fa-map"></i>
                                </button>
                            </div>
                            <span style="color:red !important;">{{ $errors->first('lokasi_kejadian') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="row">
                                <label for="lokasi_kejadian" class="col-sm-2 col-form-label">Koordinat Lokasi<span
                                        class="text-danger">*</span>
                                    <p style="color: red; font-size:10px;">Klik peta untuk isi koordinat lokasi</p>
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="map-lat" class="form-control" name="lat"
                                        placeholder="Latitude">
                                    <span style="color:red !important;">{{ $errors->first('latitude') }}</span>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" id="map-lng" class="form-control" name="lng"
                                        placeholder="Longitude">
                                    <span style="color:red !important;">{{ $errors->first('longitude') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="penyebab_bencana" class="col-sm-2 col-form-label">Penyebab Bencana <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="penyebab_bencana" id="penyebab_bencana"
                                value="{{ old('penyebab_bencana') }}">
                            <span style="color:red !important;">{{ $errors->first('penyebab_bencana') }}</span>
                        </div>
                    </div>
                    <hr>
                    <b style="color: grey; font-size:16px;">Dampak Bencana</b>
                    <div class="form-group row mt-3">
                        <label for="dampak_bencana_rr" class="col-sm-2 col-form-label">Rusak Ringan (RR)</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="dampak_bencana_rr" id="dampak_bencana_rr"
                                value="{{ old('dampak_bencana_rr') }}">
                            <span style="color:red !important;">{{ $errors->first('dampak_bencana_rr') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dampak_bencana_rs" class="col-sm-2 col-form-label">Rusak Sedang (RS)</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="dampak_bencana_rs" id="dampak_bencana_rs"
                                value="{{ old('dampak_bencana_rs') }}">
                            <span style="color:red !important;">{{ $errors->first('dampak_bencana_rs') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dampak_bencana_rb" class="col-sm-2 col-form-label">Rusak Berat (RB)</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="dampak_bencana_rb" id="dampak_bencana_rb"
                                value="{{ old('dampak_bencana_rb') }}">
                            <span style="color:red !important;">{{ $errors->first('dampak_bencana_rb') }}</span>
                        </div>
                    </div>
                    <hr>
                    <b style="color: grey; font-size:16px;">Korban Jiwa</b>
                    <div class="form-group row mt-3">
                        <label for="korban_jiwa_md" class="col-sm-2 col-form-label">Meninggal Dunia (MD)</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="korban_jiwa_md" id="korban_jiwa_md"
                                value="{{ old('korban_jiwa_md') }}">
                            <span style="color:red !important;">{{ $errors->first('korban_jiwa_md') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="korban_jiwa_lr" class="col-sm-2 col-form-label">Luka Ringan (LR)</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="korban_jiwa_lr" id="korban_jiwa_lr"
                                value="{{ old('korban_jiwa_lr') }}">
                            <span style="color:red !important;">{{ $errors->first('korban_jiwa_lr') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="korban_jiwa_lb" class="col-sm-2 col-form-label">Luka Berat (LB)</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="korban_jiwa_lb" id="korban_jiwa_lb"
                                value="{{ old('korban_jiwa_lb') }}">
                            <span style="color:red !important;">{{ $errors->first('korban_jiwa_lb') }}</span>
                        </div>
                    </div>
                    <hr>
                    <b style="color: grey; font-size:16px;">Pengungsi Jiwa/KK</b>
                    <div class="form-group row mt-3">
                        <label for="pengungsi_jiwa" class="col-sm-2 col-form-label">Jiwa</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="pengungsi_jiwa" id="pengungsi_jiwa"
                                value="{{ old('pengungsi_jiwa') }}">
                            <span style="color:red !important;">{{ $errors->first('pengungsi_jiwa') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pengungsi_kk" class="col-sm-2 col-form-label">KK</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="pengungsi_kk" id="pengungsi_kk"
                                value="{{ old('pengungsi_kk') }}">
                            <span style="color:red !important;">{{ $errors->first('pengungsi_kk') }}</span>
                        </div>
                    </div>
                    <hr>
                    <b style="color: grey; font-size:16px;">Informasi Pelapor/Instansi <span
                            style="color: red">*</span></b>
                    <div class="form-group row mt-3">
                        <label for="nama_pelapor" class="col-sm-2 col-form-label">Nama Pelapor <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_pelapor" id="nama_pelapor"
                                value="{{ old('nama_pelapor') }}">
                            <span style="color:red !important;">{{ $errors->first('nama_pelapor') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telp_pelapor" class="col-sm-2 col-form-label">No Telp Darurat <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="telp_pelapor" id="telp_pelapor"
                                value="{{ old('telp_pelapor') }}">
                            <span style="color:red !important;">{{ $errors->first('telp_pelapor') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email_pelapor" class="col-sm-2 col-form-label">Email <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" name="email_pelapor" id="email_pelapor"
                                value="{{ old('email_pelapor') }}">
                            <span style="color:red !important;">{{ $errors->first('email_pelapor') }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="image" class="col-sm-2 col-form-label">File Upload Gambar (max:2MB) <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="image" id="image"
                                value="{{ old('file') }}" accept="image/*">
                            <span style="color:red !important;">{{ $errors->first('image') }}</span>
                        </div>
                    </div>
                    <hr>
                    <b style="color: grey; font-size:16px;">Kondisi Umum / Kronologis</b>
                    <div class="form-group row mt-3">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="kondisi_umum" id="kondisi_umum" rows="5"></textarea>
                            <span style="color:red !important;">{{ $errors->first('kondisi_umum') }}</span>
                        </div>
                    </div>
                    <hr>
                    <b style="color: grey; font-size:16px;">Kegiatan/Assesment/Upaya Penanganan Darurat yang di lakukan</b>
                    <div class="form-group row mt-3">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="kegiatan" id="kegiatan" rows="5"></textarea>
                            <span style="color:red !important;">{{ $errors->first('kegiatan') }}</span>
                        </div>
                    </div>
                    <hr>
                    <b style="color: grey; font-size:16px;">Kendala/Kebutuhan mendesask/Potensi Bencana Susulan</b>
                    <div class="form-group row mt-3">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="kendala" id="kendala" rows="5"></textarea>
                            <span style="color:red !important;">{{ $errors->first('kendala') }}</span>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            {!! htmlFormSnippet() !!}
                            <span style="color:red !important;">{{ $errors->first('g-recaptcha-response') }}</span>
                        </div>
                    </div>
                    <div class="my-3">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="text-center"><button type="submit" class="btn btn-primary">Kirim Laporan</button></div>
                    {{ Form::close() }}
                </div>

            </div>

        </div>
    </section>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <input class="form-control controls mt-1" id="pac-input" type="text"
                        placeholder="Ketik Lokasi Kejadian Bencana" />
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
@stop
@section('css')
    <style>
        .contact .kontak-email-form {
            box-shadow: 0 0 30px rgba(214, 215, 216, 0.4);
            padding: 30px;
        }

        .contact .kontak-email-form input {
            padding: 10px 15px;
        }

        .contact .kontak-email-form input,
        .contact .kontak-email-form textarea {
            border-radius: 0;
            box-shadow: none;
            font-size: 14px;
        }

        .contact .kontak-email-form .form-group {
            margin-bottom: 20px;
        }

        .contact .kontak-email-form button[type=submit] {
            background: #044085;
            border: 0;
            padding: 10px 30px;
            color: #fff;
            transition: 0.4s;
            border-radius: 4px;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

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

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-container {
            z-index: 100000 !important;
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
@section('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTb2js8Dp-x_0Lcos0Zj4vS6uDTvSDlN8&callback=initAutocomplete&libraries=places&v=weekly&channel=2"
        async></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.sel-provinsi').on('change', function() {
                onChangeSelect('{{ route('cities') }}', $(this).val(), 'kabupaten');
            });

            $('.sel-kabupaten').on('change', function() {
                onChangeSelect('{{ route('districts') }}', $(this).val(), 'kecamatan');
            });

            $('.sel-kecamatan').on('change', function() {
                onChangeSelect('{{ route('villages') }}', $(this).val(), 'kelurahan');
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
                            $('#' + name).append('<option value="' + key + '">' + value +
                                '</option>');
                        });
                    }
                });
            }

            $('body').on('click', '#button-lokasi_kejadian', function() {
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.btn-action-close', function() {
                $('#ajaxModel').modal('hide');
            });

            $('body').on('click', '.btn-action-pick', function() {
                $('#ajaxModel').modal('hide');
            });

        });

        function initAutocomplete() {
            const _center = new google.maps.LatLng(-6.364233, 106.272860);
            const map = new google.maps.Map(document.getElementById("map"), {
                center: _center,
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true,
                mapTypeControl: false,
                scaleControl: true,
                zoomControl: true
            });

            const input = document.getElementById("pac-input");
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
                        console.log("Returned place contains no geometry");
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
                            //                        icon,
                            title: place.name,
                            position: place.geometry.location,
                            label: {
                                fontFamily: "'Font Awesome 5 Free'",
                                text: '\uf1ad', //icon code
                                fontWeight: '500', //careful! some icons in FA5 only exist for specific font weights
                                color: '#FFFFFF', //color of the text inside marker
                            },
                        })
                    );

                    document.getElementById("lokasi_kejadian").value = place.formatted_address;
                    document.getElementById("map-lat").value = place.geometry.location.lat();
                    document.getElementById("map-lng").value = place.geometry.location.lng();
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
@stop
