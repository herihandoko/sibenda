<?php

namespace App\Http\Controllers\Admin\DataBencana;

use App\DataTables\DataBencana\DataKejadianDataTable;
use App\Http\Controllers\Controller;
use App\Models\DataBencana\DataBencana;
use Illuminate\Http\Request;
use App\Models\DataBencana\DataLokasi;
use App\Models\LaporanKejadian;
use Auth;
use App\Models\Master\JenisBencana;
use DB;

class DataKejadianController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:laporan-kejadian-index|laporan-kejadian-create|laporan-kejadian-edit|laporan-kejadian-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:laporan-kejadian-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:laporan-kejadian-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:laporan-kejadian-delete', ['only' => ['destroy']]);
    }

    public function index(DataKejadianDataTable $dataBencanaDataTable)
    {
        return $dataBencanaDataTable->render('admin.datakejadian.dataBencanaIndex');
    }

    public function create()
    {
        return view('admin.datakejadian.dataBencanaCreate');
    }

    public function store(Request $request)
    {
        $rules = [
            'jenis_bencana_id' => 'required',
            'tgl_kejadian' => 'required',
            'jam_kejadian' => 'required',
            'kondisi_cuaca' => 'required',
            'potensi_susulan' => 'required',
            'penyebab_bencana' => 'required',
            'akses_lokasi' => 'required',
            'sarana_trans' => 'required',
            'jalur_komunikasi_id' => 'required',
            'keadaan_listrik' => 'required',
            'keadaan_air' => 'required',
            'faskes' => 'required',
        ];

        $customMessages = [
            'jenis_bencana_id.required' => trans('Jenis Bencana belum dipilih'),
        ];

        $this->validate($request, $rules, $customMessages);
        $dataBencana = new DataBencana();
        $dataBencana->jenis_bencana_id = $request->jenis_bencana_id;
        $dataBencana->luas_genangan = $request->luas_genangan;
        $dataBencana->tinggi_genangan = $request->tinggi_genangan;
        $dataBencana->tgl_kejadian = $request->tgl_kejadian;
        $dataBencana->jam_kejadian = $request->jam_kejadian;
        $dataBencana->kondisi_cuaca = $request->kondisi_cuaca;
        $dataBencana->potensi_susulan = $request->potensi_susulan;
        $dataBencana->penyebab_bencana = $request->penyebab_bencana;
        $dataBencana->deskripsi_bencana = $request->deskripsi_bencana;
        $dataBencana->akses_lokasi = $request->akses_lokasi;
        $dataBencana->sarana_trans = $request->sarana_trans;
        $dataBencana->jalur_komunikasi_id = $request->jalur_komunikasi_id;
        $dataBencana->keadaan_listrik = $request->keadaan_listrik;
        $dataBencana->keadaan_air = $request->keadaan_air;
        $dataBencana->faskes = $request->faskes;
        $dataBencana->created_by = Auth::guard('admin')->user()->id;
        if ($dataBencana->save()) {
            $provs = $request->provinsi;
            $kab = $request->kabupaten;
            $kec = $request->kecamatan;
            $kel = $request->kelurahan;
            $latLng = $request->latlng;
            $userId = Auth::guard('admin')->user()->id;
            $insert = [];
            foreach ($provs as $key => $val) {
                $location = explode(',', $latLng[$key]);
                if (count($location) == 2) {
                    $insert[] = [
                        'id_databencana' => $dataBencana->id,
                        'provinsi' => $val,
                        'kabupaten' => $kab[$key],
                        'kecamatan' => $kec[$key],
                        'kelurahan' => $kel[$key],
                        'lat' => $location[0],
                        'long' => $location[1],
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => $userId,
                    ];
                    $mBencana = JenisBencana::find($dataBencana->jenis_bencana_id);
                    $params = [
                        [
                            "attributes" => [
                                "jenis_bencana" => $mBencana->name
                            ],
                            "geometry" => [
                                "x" => $location[1],
                                "y" => $location[0],
                                "spatialReference" => [
                                    "wkid" => 4326
                                ]
                            ]
                        ]
                    ];
                    $this->insertGis($params);
                }
            }
            if ($insert) {
                DataLokasi::insert($insert);
            }
        }
        $notification = trans('admin.Created Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.data.data-bencana.index')->with($notification);
    }

    public function edit($id)
    {
        $dataBencana = LaporanKejadian::select(
            'data_laporan_kejadian.id',
            'data_laporan_kejadian.jenis_bencana',
            'data_laporan_kejadian.tgl_kejadian',
            'data_laporan_kejadian.waktu_kejadian',
            'data_laporan_kejadian.lokasi_kejadian',
            'data_laporan_kejadian.penyebab_bencana',
            'data_laporan_kejadian.dampak_bencana_rr',
            'data_laporan_kejadian.dampak_bencana_rs',
            'data_laporan_kejadian.dampak_bencana_rb',
            'data_laporan_kejadian.korban_jiwa_md',
            'data_laporan_kejadian.korban_jiwa_lr',
            'data_laporan_kejadian.korban_jiwa_lb',
            'data_laporan_kejadian.pengungsi_jiwa',
            'data_laporan_kejadian.pengungsi_kk',
            'data_laporan_kejadian.nama_pelapor',
            'data_laporan_kejadian.telp_pelapor',
            'data_laporan_kejadian.email_pelapor',
            'data_laporan_kejadian.dokumentasi',
            'data_laporan_kejadian.kondisi_umum',
            'data_laporan_kejadian.kegiatan',
            'data_laporan_kejadian.kendala',
            'data_laporan_kejadian.created_at',
            'data_laporan_kejadian.updated_at',
            'data_laporan_kejadian.lat',
            'data_laporan_kejadian.lng',
            'data_laporan_kejadian.nomor_laporan',
            'data_laporan_kejadian.status',
            'data_laporan_kejadian.dokumentasi',
            DB::raw('indonesia_cities.code AS kode_kota'),
            DB::raw('indonesia_cities.name AS nama_kota'),
            DB::raw('indonesia_districts.code AS kode_kec'),
            DB::raw('indonesia_districts.name AS nama_kec'),
            DB::raw('indonesia_villages.code AS kode_kel'),
            DB::raw('indonesia_villages.name AS nama_kel')
        )->join('indonesia_cities', 'indonesia_cities.id', '=', 'data_laporan_kejadian.kabupaten')
            ->join('indonesia_districts', 'indonesia_districts.id', '=', 'data_laporan_kejadian.kecamatan')
            ->join('indonesia_villages', 'indonesia_villages.id', '=', 'data_laporan_kejadian.kelurahan')
            ->where('data_laporan_kejadian.id', $id)
            ->first();
        return view('admin.datakejadian.dataBencanaEdit', compact('dataBencana'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'status' => 'required',
        ];

        $customMessages = [
            'status.required' => trans('Status belum dipilih'),
        ];

        $this->validate($request, $rules, $customMessages);

        $lapKejadian = LaporanKejadian::find($id);
        $lapKejadian->status = $request->status;
        $lapKejadian->save();

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.data.data-kejadian.index')->with($notification);
    }

    public function destroy($id)
    {
        $dataLaporan = LaporanKejadian::findOrFail($id);
        $dataLaporan->delete();
    }
    public function insertGis($params)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('URL_GIS'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'adds=' . urlencode(json_encode($params)),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
        curl_exec($curl);
        curl_close($curl);
        return true;
    }
}
