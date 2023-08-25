@php
$page_title = 'Admin | Data Korban';
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
                <h1>Tambah Data Korban</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{route('admin.data.data-korban.index')}}" role="button">
                <i class="fas fa-arrow-circle-left"></i> {{trans('admin.Back')}}
            </a>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.data.data-korban.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Kode Bencana *</label>
                                        <select class="form-control" name="id_databencana" id="id_databencana" required autofocus>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach (App\Models\DataBencana\DataBencana::where('is_deleted', 0)->get() as $dataBencana)
                                                <option value="{{$dataBencana->id}}">{{$dataBencana->kode}} - {{ $dataBencana->jenisBencanas->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nama Korban *</label>
                                        <input type="text" class="form-control" name="nama_korban" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                         <label for="">NIK *</label>
                                         <input type="text" class="form-control" name="nik" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                         <label for="">Jenis Kelamin *</label>
                                         <select class="form-control" name="jns_kelamin" required>
                                             <option value="" disabled selected>-- Pilih --</option>
                                             <option value="1">Laki - Laki</option>
                                             <option value="2">Perempuan</option>
                                         </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tgl Lahir *</label>
                                        <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Usia</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" name="usia" id="usia" readonly>
                                            <span class="input-group-text">Tahun</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Kategori *</label>
                                        <select class="form-control" name="kategori_korban_id" id="kategori_korban_id" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach (App\Models\Master\KategoriKorban::where('is_deleted', 0)->get() as $kategoriKorban)
                                                <option value="{{$kategoriKorban->id}}">{{$kategoriKorban->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6" id="div_status_korban">
                                    <div class="form-group">
                                        <label for="">Status Korban *</label>
                                        <select class="form-control" name="status_korban_id" id="status_korban_id" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach (App\Models\Master\StatusKorban::where('is_deleted', 0)->get() as $statusKorban)
                                                <option value="{{$statusKorban->id}}">{{$statusKorban->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3" id="div_mengungsi" style="display: none;">
                                    <div class="form-group">
                                        <label for="">Mengungsi *</label>
                                        <select class="form-control" name="mengungsi" id="mengungsi">
                                            <option value="" disabled selected>-- Pilih --</option>
                                            <option value="1">Ya</option>
                                            <option value="2">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12" id="div_lokasi_pengungsian" style="display: none;">
                                    <div class="form-group">
                                        <label for="">Kode Lokasi Pengungsian *</label>
                                        <select class="form-control" name="lokasi_pengungsian_id" id="lokasi_pengungsian_id">
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach (App\Models\LokasiPengungsian\LokasiPengungsian::where('is_deleted', 0)->get() as $lokasiPengungsian)
                                                <option value="{{$lokasiPengungsian->id}}">{{$lokasiPengungsian->kode}} - {{ $lokasiPengungsian->jenisHunians->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-12" id="div_alamat_rs" style="display: none;">
                                    <div class="form-group">
                                        <label for="">Penanganan RS *</label>
                                        <input type="text" class="form-control" name="alamat_rs">
                                    </div>
                                </div>
                                
                                <div class="col-md-6" id="div_lokasi_hilang" style="display: none;">
                                    <div class="form-group">
                                        <label for="">Lokasi Hilang *</label>
                                        <input type="text" class="form-control" name="lokasi_hilang">
                                    </div>
                                </div>
                                
                                <div class="col-md-6" id="div_ahli_waris" style="display: none;">
                                    <div class="form-group">
                                        <label for="">Ahli Waris *</label>
                                        <input type="text" class="form-control" name="ahli_waris">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3" id="div_disabilitas">
                                    <div class="form-group">
                                        <label for="">Disabilitas *</label>
                                        <select class="form-control" name="disabilitas" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            <option value="1">Ya</option>
                                            <option value="2">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3" id="div_hamil">
                                    <div class="form-group">
                                        <label for="">Hamil *</label>
                                        <select class="form-control" name="hamil" id="hamil" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            <option value="1">Ya</option>
                                            <option value="2">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-2" id="div_usia_kehamilan" style="display: none;">
                                    <div class="form-group">
                                        <label for="">Usia Kehamilan (minggu) *</label>
                                        <input type="number" class="form-control" name="usia_hamil" id="usia_hamil">
                                    </div>
                                </div>
                                
                                <div class="col-md-3" id="div_jenis_kehamilan" style="display: none;">
                                    <div class="form-group">
                                        <label for="">Jenis Kehamilan</label>
                                        <input type="text" class="form-control" name="jenis_hamil" id="jenis_hamil" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-6" id="div_menyusui">
                                    <div class="form-group">
                                        <label for="">Menyusui *</label>
                                        <select class="form-control" name="menyusui" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            <option value="1">Ya</option>
                                            <option value="2">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                         <label for="">Alamat *</label>
                                         <textarea class="form-control h-100" name="alamat" rows="3" required></textarea>
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
                                                <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Kabupaten/Kota *</label>
                                        <select class="form-control" name="kabupaten" id="kabupaten" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Kecamatan *</label>
                                        <select class="form-control" name="kecamatan" id="kecamatan" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Desa/Kelurahan *</label>
                                        <select class="form-control" name="kelurahan" id="kelurahan" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">RT</label>
                                        <input type="number" name="rt" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">RW</label>
                                        <input type="number" name="rw" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                         <label for="">Keterangan</label>
                                         <textarea class="form-control h-100" name="keterangan" rows="3"></textarea>
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
        
        $("#status_korban_id").change(function(){
            var stsKorbanIdValue = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.data.data-korban.getName') }}",
                data: {id: stsKorbanIdValue},
                success: function(data, textStatus, jqXHR) {
                    if(data['name'] == 'Sehat/Luka Ringan') {
                        $("#div_status_korban").attr('class', 'col-md-3');
                        $("#div_mengungsi").show(900);
                        $("[name='mengungsi']").attr("required", true);
                        
                        $("#div_alamat_rs").hide(900);
                        $("[name='alamat_rs']").val('');
                        $("[name='alamat_rs']").attr("required", false);
                        
                        $("#div_lokasi_hilang").hide(900);
                        $("#div_ahli_waris").hide(900);
                        $("[name='lokasi_hilang']").attr("required", false);
                        $("[name='lokasi_hilang']").val('');
                        $("[name='ahli_waris']").attr("required", false);
                        $("[name='ahli_waris']").val('');
                    } else if(data['name'] == 'Luka Berat') {
                        $("#div_alamat_rs").show(900);
                        $("[name='alamat_rs']").attr("required", true);
                        
                        $("#div_status_korban").attr('class', 'col-md-6');
                        $("#div_mengungsi").hide();
                        $("[name='mengungsi']").attr("required", false);
                        $("#mengungsi").val(null).trigger("change");
                        
                        $("#div_lokasi_hilang").hide(900);
                        $("#div_ahli_waris").hide(900);
                        $("[name='lokasi_hilang']").attr("required", false);
                        $("#lokasi_hilang").val(null).trigger("change");
                        $("[name='ahli_waris']").attr("required", false);
                        $("#ahli_waris").val(null).trigger("change");
                        
                        $("#div_lokasi_pengungsian").hide(900);
                        $("[name='lokasi_pengungsian_id']").attr("required", false);
                        $("#lokasi_pengungsian_id").val(null).trigger("change");
                    } else if(data['name'] == 'Hilang') {
                        $("#div_lokasi_hilang").show(900);
                        $("#div_ahli_waris").show(900);
                        $("#div_ahli_waris").attr('class', 'col-md-6');
                        $("[name='lokasi_hilang']").attr("required", true);
                        $("[name='ahli_waris']").attr("required", true);
                        
                        $("#div_status_korban").attr('class', 'col-md-6');
                        $("#div_mengungsi").hide();
                        $("[name='mengungsi']").attr("required", false);
                        $("[name='mengungsi']").val('');
                        
                        $("#div_alamat_rs").hide(900);
                        $("[name='alamat_rs']").attr("required", false);
                        $("[name='alamat_rs']").val('');
                        
                        $("#div_lokasi_pengungsian").hide(900);
                        $("[name='lokasi_pengungsian_id']").attr("required", false);
                        $("[name='lokasi_pengungsian_id']").val('');
                    } else if(data['name'] == 'Meninggal') {
                        $("#div_ahli_waris").show(900);
                        $("#div_ahli_waris").attr('class', 'col-md-12');
                        $("[name='ahli_waris']").attr("required", true);
                        
                        $("#div_status_korban").attr('class', 'col-md-6');
                        $("#div_mengungsi").hide();
                        $("[name='mengungsi']").attr("required", false);
                        $("[name='mengungsi']").val('');
                        
                        $("#div_alamat_rs").hide(900);
                        $("[name='alamat_rs']").attr("required", false);
                        $("[name='alamat_rs']").val('');
                        
                        $("#div_lokasi_hilang").hide(900);
                        $("[name='lokasi_hilang']").attr("required", false);
                        $("[name='lokasi_hilang']").val('');
                        
                        $("#div_lokasi_pengungsian").hide(900);
                        $("[name='lokasi_pengungsian_id']").attr("required", false);
                        $("[name='lokasi_pengungsian_id']").val('');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                }
            });
        });
        
        $('#mengungsi').on('change', function() {
            var mengungsi = $(this).val();
            if(mengungsi == 1) {
                $("#div_lokasi_pengungsian").show(900);
                $("[name='lokasi_pengungsian_id']").attr("required", true);
            } else {
                $("#div_lokasi_pengungsian").hide(900);
                $("[name='lokasi_pengungsian_id']").attr("required", false);
                $("[name='lokasi_pengungsian_id']").val('');
            }
        });
        
        $('#tgl_lahir').on('change', function () {
            var birthdate = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.data.data-korban.getBirthdate') }}",
                data: {tgl_lahir: birthdate},
                success: function(data, textStatus, jqXHR) {
                    $('#usia').val(data);
                },
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                }
            });
        });
        
        $('#hamil').on('change', function() {
            var hamil = $(this).val();
            if(hamil == 1) {
                $("#div_disabilitas").attr('class', 'col-md-2');
                $("#div_hamil").attr('class', 'col-md-2');
                $("#div_menyusui").attr('class', 'col-md-3');
                
                $("#div_usia_kehamilan").show(900);
                $("#div_jenis_kehamilan").show(900);
                
                $("[name='usia_hamil']").attr("required", true);
            } else {
                $("#div_usia_kehamilan").hide();
                $("#div_jenis_kehamilan").hide();
                
                $("#div_disabilitas").attr('class', 'col-md-3');
                $("#div_hamil").attr('class', 'col-md-3');
                $("#div_menyusui").attr('class', 'col-md-6');
                
                $("[name='usia_hamil']").attr("required", false);
                $("[name='usia_hamil']").val('');
                $("[name='jenis_hamil']").val('');
            }
        });
        
        $('#usia_hamil').on('input', function() {
            var usia_hamil = $(this).val();
            if(usia_hamil >= 27) {
                $('#jenis_hamil').val('Tua');
            } else if(usia_hamil > 0 && usia_hamil < 27) {
                $('#jenis_hamil').val('Muda');
            } else {
                $('#jenis_hamil').val('');
            }
        });
    </script>
@endpush