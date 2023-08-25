@extends('frontend.page')
@section('title_prefix', 'Beranda - Laporan Kejadian')
@section('title', 'Beranda')
@section('content')
    <section id="bizland" class="d-flex align-items-center" style="padding: 20px 0;">
        <div class="container">
            <div class="section-title">
                <h3>Data Bencana</h3>
                <p>Data Kejadian Bencana di Provinsi Banten</p>
            </div>
            <div class="contact">
                <div class="row aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12">
                        <form method="post" role="form" class="kontak-email-form" id="form-filter-data-bencana">
                            <div class="row mb-2">
                                <div class="col-sm-12 col-md-3">
                                    <label style="font-size: 14px;">Provinsi</label>
                                    <div class="input-group" style="height: 38px !important;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-list"></i></span>
                                        </div>
                                        <select class="form-control sel-provinsi" name="provinsi" id="provinsi">
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach ($provinces->where('code', 36) as $item)
                                                <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label style="font-size: 14px;">Kabupaten/Kota</label>
                                    <div class="input-group" style="height: 38px !important;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-list"></i></span>
                                        </div>
                                        <select class="form-control sel-kabupaten" name="kabupaten" id="kabupaten">
                                            <option value="">Pilih Kabupaten Kota</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label style="font-size: 14px;">Kecamatan</label>
                                    <div class="input-group" style="height: 38px !important;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-list"></i></span>
                                        </div>
                                        <select class="form-control sel-kecamatan" name="kecamatan" id="kecamatan">
                                            <option value="">Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label style="font-size: 14px;">Kelurahan/Desa</label>
                                    <div class="input-group" style="height: 38px !important;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-list"></i></span>
                                        </div>
                                        <select class="form-control sel-kelurahan" name="kelurahan" id="kelurahan">
                                            <option value="">Pilih Kelurahan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <label style="font-size: 14px;">Jenis Kejadian Bencana</label>
                                    <div class="input-group" style="height: 38px !important;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-list"></i></span>
                                        </div>
                                        <select class="form-control" name="jenis_bencana" id="jenis_bencana">
                                            <option value="">Pilih Jenis Bencana</option>
                                            @foreach ($jenisbencana as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label style="font-size: 14px;">Tanggal Awal</label>
                                    <div class="input-group" style="height: 38px !important;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-th"></i></span>
                                        </div>
                                        <input type="date" class="form-control" placeholder="Masukan Tanggal Awal"
                                            aria-label="start_date" name="start_date" id="start_date">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label style="font-size: 14px;">Tanggal Akhir</label>
                                    <div class="input-group" style="height: 38px !important;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-th"></i></span>
                                        </div>
                                        <input type="date" class="form-control" placeholder="Masukan Tanggal Akhir"
                                            aria-label="end_date" name="end_date" id="end_date">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group" style="padding-top: 20px;">
                                        <button type="button" class="btn btn-primary full-width" id="btn-filter-data-bencana" style="width:100%">Cari Data</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div style="box-shadow: 0 0 5px rgba(214, 215, 216, 0.4); padding:10px !important;">
                <table id="data-bencana-table" class="table dataTable no-footer display nowrap" style="width:100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Bencana</th>
                            <th>Tanggal Kejadian</th>
                            <th>Waktu Kejadian</th>
                            <th>Kabupaten/Kota</th>
                            <th>Kecamatan</th>
                            <th>Desa/Kelurahan</th>
                            <th>Kp./Ling./Alamat</th>
                            <th>Koordinat</th>
                            <th>Penyebab Kejadian</th>
                            <th>Deskripsi</th>
                            <th>Dokumentasi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="map"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-action-close" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/admin/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link href="{{ asset('assets/vendor/datatables/extensions/Buttons/css/buttons.bootstrap.min.css') }}"
        rel="stylesheet" />
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTb2js8Dp-x_0Lcos0Zj4vS6uDTvSDlN8&libraries=places&v=weekly&channel=2"
        async></script>
    <style>
        .contact .kontak-email-form {
            box-shadow: 0 0 30px rgba(214, 215, 216, 0.4);
            padding: 30px;
        }

        .contact .kontak-email-form span {
            padding: 10px 10px;
        }

        .contact .kontak-email-form span {
            border-radius: 0;
            box-shadow: none;
        }

        .contact .kontak-email-form input,
        .contact .kontak-email-form select,
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
        
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.details-control:first-child:before { display: none;}
table.dataTable th, table.dataTable td { white-space: normal; }
.child {table-layout:fixed} .child td {word-wrap:break-word; white-space: normal !important;}
    </style>
@stop
@section('js')
    <script src="{{ url('assets/admin/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ url('assets/admin/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/extensions/Buttons/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/extensions/Buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/extensions/Buttons/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/extensions/Buttons/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/extensions/Buttons/js/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/extensions/Buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/extensions/Buttons/js/buttons.print.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $('body').on('click', '.btn-copy-lokasi', function() {
                var textArea = document.createElement("textarea");
                textArea.value = $(this).data('value');
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand("copy");
                textArea.remove();
                $(this).attr('title', 'Copied')
                    .tooltip('fixTitle')
                    .tooltip('show');
            });
            
            var _tableContent = $('#data-bencana-table').DataTable({
                dom: 'Bfrtip',
                pageLength: 15,
                buttons: [
                    'copy', 'csv', 'excel',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        text: 'Simpan PDF',
                        header: true,
                        title: 'Data Bencana Provinsi Banten',
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 8;
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Cetak',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'Data Bencana Provinsi Banten',
                        customize: function(win) {

                            var last = null;
                            var current = null;
                            var bod = [];

                            var css = '@page { size: landscape; }',
                                head = win.document.head || win.document.getElementsByTagName(
                                    'head')[0],
                                style = win.document.createElement('style');

                            style.type = 'text/css';
                            style.media = 'print';

                            if (style.styleSheet) {
                                style.styleSheet.cssText = css;
                            } else {
                                style.appendChild(win.document.createTextNode(css));
                            }

                            head.appendChild(style);

                            $(win.document.body)
                                .css('font-size', '8px');

                            $(win.document.body)
                                .css('font-size', '8px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', '8px');
                        }
                    }
                ],
                paging: true,
                processing: true,
                serverSide: true,
                // scrollX: true,
                searching: true,
                lengthChange: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('databencana.fetch') }}",
                    type: "GET",
                    data: function(data) {
                        const _filter = {};
                        $("form#form-filter-data-bencana :input").each(function() {
                            var inputName = $(this).attr('id');
                            if (inputName !== undefined) {
                                var _field = $(document).find('[name="' + inputName + '"]');
                                if (_field.val())
                                    _filter[inputName] = _field.val();
                            }
                        });
                        data.filter = _filter;
                    },
                },
                columns: [{
                        data: 'rownum',
                        name: 'rownum',
                        orderable: false
                    },
                    {
                        data: 'jenis_bencana',
                        name: 'jenis_bencana'
                    },
                    {
                        data: 'tgl_kejadian',
                        name: 'tgl_kejadian'
                    },
                    {
                        data: 'jam_kejadian',
                        name: 'jam_kejadian'
                    },
                    {
                        data: 'nama_kota',
                        name: 'nama_kota'
                    },
                    {
                        data: 'nama_kec',
                        name: 'nama_kec'
                    },
                    {
                        data: 'nama_kel',
                        name: 'nama_kel'
                    },
                    {
                        data: 'lokasi',
                        name: 'lokasi'
                    },
                    {
                        data: 'koordinat',
                        name: 'koordinat'
                    },
                    {
                        data: 'penyebab_bencana',
                        name: 'penyebab_bencana'
                    },
                    {
                        data: 'deskripsi_bencana',
                        name: 'deskripsi_bencana'
                    },
                    {
                        data: 'dokumentasi',
                        name: 'dokumentasi'
                    }
                ]
            });

            $('#btn-filter-data-bencana').on('click', function() {
                _tableContent.draw();
            });

            $('body').on('click', 'button.btn-detail-koordinat', function(e) {
                $('#ajaxModel').modal('show');
                const _center = new google.maps.LatLng(-6.364233, 106.272860);
                const map = new google.maps.Map(document.getElementById("map"), {
                    center: _center,
                    zoom: 9,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true,
                    mapTypeControl: false,
                    scaleControl: true,
                    zoomControl: true
                });
                const myLatlng = {
                    lat: $(this).data('lat'),
                    lng: $(this).data('lng')
                };
                const marker = new google.maps.Marker({
                    position: myLatlng,
                    map,
                    title: "Click to zoom",
                });
            });

            $('body').on('click', '.btn-action-close', function() {
                $('#ajaxModel').modal('hide');
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
        });
    </script>
@stop
