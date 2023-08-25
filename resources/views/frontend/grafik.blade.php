@extends('frontend.page')
@section('title_prefix', 'Beranda - Laporan Kejadian')
@section('title', 'Beranda')
@section('content')
    <section id="bizland" class="d-flex align-items-center" style="padding: 20px 0;">
        <div class="container">
            <div class="section-title">
                <h3>Grafik</h3>
                <p>Grafik Kejadian Bencana di Provinsi Banten</p>
                <div class="row d-flex justify-content-center">
                    <select class="form-control text-center" id="tahun-kejadian-1" style="width:150px !important;">
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                    </select>
                </div>
            </div>
            <div class="row p-2" style="box-shadow: 0 0 30px rgba(214, 215, 216, 0.4); padding:10px;">
                <div class="col-sm-12 col-md-8">
                    <div id="reportPage">
                        <div id="chartContainer">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="row" id="element-source-print">
                        @foreach ($jenisbencana as $key => $value)
                            <div class="col-md-6">
                                <div class="card mt-1 border-danger"
                                    style="border-top-left-radius: 21px 21px; border-bottom-left-radius: 21px 21px; border-top-right-radius: 0rem !important; border-bottom-right-radius: 0rem !important; border-color:#044085 !important;">
                                    <div class="card-body" style="padding: 0rem 0rem !important;">
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="{{ asset($value->icon) }}" width="42px">
                                            </div>
                                            <div class="col-9">
                                                <div class="row">
                                                    <span
                                                        style="font-size: 1rem; font-weight:bold !important; font-size:1.2em; ">{{ $value->ttl_bencana }}</span>
                                                </div>
                                                <div class="row align-self-end">
                                                    <span
                                                        style="font-size: 1rem; font-weight:bold !important; font-size:8px; ">{{ $value->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="#" id="downloadPdf" class="btn btn-primary btn-block"
                        style="width:100%; margin-top:10px;"><i class="fa fa-download"></i> Unduh
                        Grafik </a>
                </div>
            </div>
            <div class="row p-2 mt-2" style="box-shadow: 0 0 30px rgba(214, 215, 216, 0.4); padding:10px;">
                <div class="container">
                    <div class="section-title text-center">
                        {{-- <h3>Grafik</h3> --}}
                        <p>Grafik Kejadian Bencana di Wilayah Provinsi Banten</p>
                        <div class="row d-flex justify-content-center">
                            <select class="form-control text-center" id="tahun-kejadian-2" style="width:150px !important;">
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                            </select>
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col-sm-12 col-md-8">
                            <canvas id="myChartCities"></canvas>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="row" id="element-source-print-2">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Kabupaten/Kota</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $ttl = 0; ?>
                                        @foreach ($cities as $key => $value)
                                            <?php $ttl = $ttl + $value->ttl_kejadian; ?>
                                            <tr>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->ttl_kejadian }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th scope="row">Total Kejadian</th>
                                            <td>{{ $ttl }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <a href="#" id="downloadPdf2" class="btn btn-primary btn-block"
                                style="width:100%; margin-top:10px;"><i class="fa fa-download"></i> Unduh
                                Grafik </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('css')
    <style>
        .rotate {
            height: 140px;
            white-space: nowrap;
            width: 0;

            >div {
                transform:
                    translate(0px, 110px) rotate(-90deg);
            }

            >div>span {
                padding: 5px 5px;
            }
        }
    </style>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/jspdf@1.5.3/dist/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/html2canvas@1.4.1/dist/html2canvas.js"></script>
    <script>
        const canvas = document.getElementById('myChart');
        var _options ={
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    }
                },
                customCanvasBackgroundColor: {
                    color: 'white'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };
        var myChartFirst = new Chart( canvas, {
                type: "bar",
                data: {},
                options: _options
          });
        loadContent($('#tahun-kejadian-1').val());
        
        $('body').on('change', '#tahun-kejadian-1', function() {
           loadContent($(this).val());
        });
        
        loadContentCity($('#tahun-kejadian-2').val());
        const ctx = document.getElementById('myChartCities');
        var myChartSecond = new Chart(ctx, {
            type: 'bar',
            dadata: {},
            options: {
                plugins: {
                    legend: {
                        display: false,
                        labels: {
                            color: 'rgb(255, 99, 132)'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        $('body').on('change', '#tahun-kejadian-2', function() {
           loadContentCity($(this).val());
        });
        
        $('#downloadPdf').click(function(event) {
            event.preventDefault();
            var element = document.getElementById('element-source-print');
            html2canvas(element).then(function(canvas) {
                var doc = new jsPDF("L", "mm", "A4");
                doc.setFontSize(12);
                doc.text(100, 15, 'Grafik Kejadian Bencana di Provinsi Banten 2019 - 2023');

                doc.setFillColor(0, 0, 0, 0);

                doc.rect(10, 50, 150, 100, "F");
                var canvasImg = document.getElementById("myChart").toDataURL("image/png", 1.0);
                doc.addImage(canvasImg, 'png', 10, 50, 150, 100);

                doc.rect(180, 50, 100, 85, "F");
                var _canvasLegend = canvas.toDataURL("image/png", 1.0);
                doc.addImage(_canvasLegend, 'png', 180, 50, 100, 85);

                doc.save('grafik-kejadian-bencana-provinsi-banten-2019-2023.pdf');
            });
        });

        $('#downloadPdf2').click(function(event) {
            event.preventDefault();
            var element = document.getElementById('element-source-print-2');
            html2canvas(element).then(function(canvas) {
                var doc = new jsPDF("L", "mm", "A4");
                doc.setFontSize(12);
                doc.text(100, 15, 'Grafik Kejadian Bencana di Wilayah Provinsi Banten 2019 - 2023');

                doc.setFillColor(0, 0, 0, 0);

                doc.rect(10, 50, 150, 100, "F");
                var canvasImg = document.getElementById("myChartCities").toDataURL("image/png", 1.0);
                doc.addImage(canvasImg, 'png', 10, 50, 150, 100);

                doc.rect(180, 50, 100, 80, "F");
                var _canvasLegend = canvas.toDataURL("image/png", 1.0);
                doc.addImage(_canvasLegend, 'png', 180, 50, 100, 80);

                doc.save('grafik-kejadian-bencana-wilayah-provinsi-banten-2019-2023.pdf');
            });
        });
        
        
        function loadContent(thn) {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: "{{ route('databencana.chart') }}",
                data:{
                    tahun:thn
                },
                success: function(data) {
                    myChartFirst.data = data;
                    myChartFirst.update();
                }
            });
        }
        
        function loadContentCity(thn) {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: "{{ route('databencana.chart_city') }}",
                data:{
                    tahun:thn
                },
                success: function(data) {
                    myChartSecond.data = data;
                    myChartSecond.update();
                }
            });
        }
    </script>
@stop
