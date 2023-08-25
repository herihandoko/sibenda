@extends('frontend.page')
@section('title_prefix', 'Beranda - SIBENDA')
@section('title', 'Beranda')
@section('content')
    <section id="bizland" class="d-flex align-items-center">
        <div class="container" data-aos="zoom-out" data-aos-delay="100"
            style="max-width: 100% !important; padding-right: var(--bs-gutter-x,.0rem) !important;padding-left: var(--bs-gutter-x,.0rem) !important;">
            <div id="map"></div>
        </div>
    </section>
    {{-- @include('frontend.partials.visitor') --}}
    @include('frontend.partials.persentase')
    <a href="{{ url('laporan-kejadian/buat-laporan') }}">
        <button class="btn-floating whatsapp">
            <i class="fa fa-edit"></i>
            <span>Buat Laporan Kejadian</span>
        </button>
    </a>
@stop
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
        integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link href="{{ asset('assets/vendor/leaflet/leaflet.legend.css') }}?v=1" rel="stylesheet">
    <style>
        #bizland {
            width: 100%;
            height: 78vh;
            background-size: cover;
            position: relative;
        }

        #map {
            height: 78vh;
            width: 100%;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }

        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }

        .legend {
            line-height: 18px;
            color: #555;
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }

        .leaflet-control-attribution.leaflet-control {
            display: none;
        }

        /** button floating */
        .btn-floating {
            position: fixed;
            right: 25px;
            overflow: hidden;
            width: 50px;
            height: 50px;
            border-radius: 100px;
            border: 0;
            z-index: 9999;
            color: white;
            transition: .2s;
        }

        .btn-floating:hover {
            width: auto;
            padding: 0 20px;
            cursor: pointer;
        }

        .btn-floating span {
            font-size: 16px;
            margin-left: 5px;
            transition: .2s;
            line-height: 0px;
            display: none;
        }

        .btn-floating:hover span {
            display: inline-block;
        }

        .btn-floating:hover img {
            margin-bottom: -3px;
        }

        .btn-floating.whatsapp {
            bottom: 25px;
            background-color: #198754;
            border: 2px solid #fff;
        }

        .btn-floating.whatsapp:hover {
            background-color: #198754;
        }
    </style>
@stop
@section('js')
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
        integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="{{ asset('assets/vendor/leaflet/leaflet.legend.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var _url = "{{ asset('assets/json/provinsi_banten.geojson') }}?v=1.3";
        var mymap = L.map('map').setView([-6.44538, 106.13756], 9);
        var geojson;
        L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaGVyaWhhbmQyNDAyIiwiYSI6ImNrcDBsOWh3eDEzcXIybmxkMHZpMjVqN2kifQ.gbu7xDRMTm6VpyXRVbaHNQ', {
                attribution: 'Map data &copy; <a href="https://bantenprov.go.id">Bantenprov.go.id</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoiaGVyaWhhbmQyNDAyIiwiYSI6ImNrcDBsOWh3eDEzcXIybmxkMHZpMjVqN2kifQ.gbu7xDRMTm6VpyXRVbaHNQ'
            }).addTo(mymap);

        var legend = L.control({
            position: 'bottomright'
        });

        var _requestKab = $.ajax({
            type: 'GET',
            dataType: 'json',
            url: "{{ route('kabkota') }}"
        });

        $.getJSON(_url, function(data) {
            geojson = L.geoJson(data, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(mymap);
        });

        legend.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'info legend');
            _requestKab.done(function(result) {
                $.each(result['data'], function(key, value) {
                    div.innerHTML += '<i style="background:' + value['color'] + ';"></i> ' + value[
                        'name'] + '<br>';
                });
            });
            return div;
        };

        legend.addTo(mymap);

        var info = L.control();
        info.onAdd = function(map) {
            this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
            this.update();
            return this._div;
        };
        info.update = function(props) {
            this._div.innerHTML = '<h4>Provinsi Banten</h4>' + (props ?
                '<b>' + props.NAMOBJ + '</b><br />' + props.WADMPR + ' <sup>2</sup>' :
                'Hover over a state');
        };
        info.addTo(mymap);

        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
            });
        }

        function highlightFeature(e) {
            var layer = e.target;
            layer.setStyle({
                weight: 2,
                color: layer.feature.properties.Warna,
                dashArray: '',
                fillOpacity: 0.9
            });

            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                layer.bringToFront();
            }
            info.update(layer.feature.properties);
        }

        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            info.update();
        }

        function zoomToFeature(e) {
            mymap.fitBounds(e.target.getBounds());
        }

        function style(feature) {
            switch (feature.id) {
                case '3601':
                    _fillC = '#1c8849';
                    _fillO = 0.5;
                    break;
                case '3602':
                    _fillC = '#cb9532';
                    _fillO = 0.5;
                    break;
                case '3603':
                    _fillC = '#bfa932';
                    _fillO = 0.5;
                    break;
                case '3604':
                    _fillC = '#b57db7';
                    _fillO = 0.5;
                    break;
                case '3671':
                    _fillC = '#c49a6c';
                    _fillO = 0.5;
                    break;
                case '3672':
                    _fillC = '#c38e88';
                    _fillO = 0.5;
                    break;
                case '3673':
                    _fillC = '#83c65f';
                    _fillO = 0.5;
                    break;
                case '3674':
                    _fillC = '#faee55';
                    _fillO = 0.5;
                    break;
                default:
                    _fillC = '#c49a6c';
                    _fillO = 0.5;
                    break;
            }
            return {
                fillColor: _fillC,
                weight: 2,
                opacity: 1,
                color: _fillC,
                dashArray: '3',
                fillOpacity: _fillO,
            };
        }

        function getColor(d) {
            return d > 1000 ? '#800026' :
                d > 500 ? '#BD0026' :
                d > 200 ? '#E31A1C' :
                d > 100 ? '#FC4E2A' :
                d > 50 ? '#FD8D3C' :
                d > 20 ? '#FEB24C' :
                d > 10 ? '#FED976' :
                '#FFEDA0';
        }

        var _request = $.ajax({
            type: 'GET',
            dataType: 'json',
            url: "{{ route('location') }}"
        });

        _request.done(function(result) {
            L.geoJSON(result.data, {
                onEachFeature: function(feature, layer) {
                    var baseballIcon = L.icon({
                        iconUrl: feature.properties.icon,
                        iconSize: [32, 32],
                        iconAnchor: [32, 32],
                        popupAnchor: [0, -28]
                    })
                    layer.setIcon(baseballIcon);
                }
            }).bindPopup(function(layer) {
                return "<strong>" + layer.feature.properties.title + "</strong>";
            }, {
                maxWidth: 300
            }).addTo(mymap);
        });

        var _requestLegend = $.ajax({
            type: 'GET',
            dataType: 'json',
            url: "{{ route('legends') }}"
        });

        _requestLegend.done(function(result) {
            L.control.Legend({
                    position: "bottomleft",
                    title: 'Legenda',
                    collapsed: false,
                    symbolWidth: 24,
                    opacity: 1,
                    column: 2,
                    legends: result.data
                })
                .addTo(mymap);
        });



        $('a[title="A JavaScript library for interactive maps"]').hide();
    </script>
@stop
