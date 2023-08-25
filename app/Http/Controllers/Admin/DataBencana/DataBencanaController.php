<?php

namespace App\Http\Controllers\Admin\DataBencana;

use App\DataTables\DataBencana\DataBencanaDataTable;
use App\Http\Controllers\Controller;
use App\Models\DataBencana\DataBencana;
use Illuminate\Http\Request;
use App\Models\DataBencana\DataLokasi;
use Auth;
use App\Models\Master\JenisBencana;

class DataBencanaController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:data-bencana-index|data-bencana-create|data-bencana-edit|data-bencana-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:data-bencana-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:data-bencana-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:data-bencana-delete', ['only' => ['destroy']]);
    }

    public function index(DataBencanaDataTable $dataBencanaDataTable)
    {
        return $dataBencanaDataTable->render('admin.databencana.dataBencanaIndex');
    }

    public function create()
    {
        return view('admin.databencana.dataBencanaCreate');
    }

    public function store(Request $request)
    {
        $rules = [
            'jenis_bencana_id' => 'required',
            'tgl_kejadian' => 'required|date_format:Y-m-d|before:tomorrow',
            'jam_kejadian' => 'required|date_format:H:i',
            // 'kondisi_cuaca' => 'required',
            // 'potensi_susulan' => 'required',
            'penyebab_bencana' => 'required',
            // 'akses_lokasi' => 'required',
            // 'sarana_trans' => 'required',
            // 'jalur_komunikasi_id' => 'required',
            // 'keadaan_listrik' => 'required',
            // 'keadaan_air' => 'required',
            // 'faskes' => 'required',
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
        $dataBencana->image_1 = $request->image_1;
        $dataBencana->image_2 = $request->image_2;
        $dataBencana->image_3 = $request->image_3;
        $dataBencana->image_4 = $request->image_4;
        $dataBencana->image_5 = $request->image_5;
        $dataBencana->image_6 = $request->image_6;
        $dataBencana->created_by = Auth::guard('admin')->user()->id;
        if ($dataBencana->save()) {
            $provs = $request->provinsi;
            $kab = $request->kabupaten;
            $kec = $request->kecamatan;
            $kel = $request->kelurahan;
            $lokasi = $request->lokasi;
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
                        'lokasi' => $lokasi[$key],
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
        $dataBencana = DataBencana::find($id);
        $lokasiBencana = DataLokasi::where('id_databencana', $id)->get();
        $rows = 0;
        return view('admin.databencana.dataBencanaEdit', compact('dataBencana', 'lokasiBencana', 'rows'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'jenis_bencana_id' => 'required',
            'tgl_kejadian' => 'required',
            'jam_kejadian' => 'required',
            // 'kondisi_cuaca' => 'required',
            // 'potensi_susulan' => 'required',
            'penyebab_bencana' => 'required',
            // 'akses_lokasi' => 'required',
            // 'sarana_trans' => 'required',
            // 'jalur_komunikasi_id' => 'required',
            // 'keadaan_listrik' => 'required',
            // 'keadaan_air' => 'required',
            // 'faskes' => 'required',
        ];

        $customMessages = [
            'jenis_bencana_id.required' => trans('Jenis Bencana belum dipilih'),
        ];

        $this->validate($request, $rules, $customMessages);

        $dataBencana = DataBencana::findOrFail($id);
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
        $dataBencana->image_1 = $request->image_1;
        $dataBencana->image_2 = $request->image_2;
        $dataBencana->image_3 = $request->image_3;
        $dataBencana->image_4 = $request->image_4;
        $dataBencana->image_5 = $request->image_5;
        $dataBencana->image_6 = $request->image_6;
        $dataBencana->updated_by = Auth::guard('admin')->user()->id;
        if ($dataBencana->save()) {
            DataLokasi::where('id_databencana', $id)->delete();
            $provs = $request->provinsi;
            $kab = $request->kabupaten;
            $kec = $request->kecamatan;
            $kel = $request->kelurahan;
            $lokasi = $request->lokasi;
            $latLng = $request->latlng;
            $userId = Auth::guard('admin')->user()->id;
            $insert = [];
            if ($provs) {
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
                            'lokasi' => $lokasi[$key],
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
            }

            if ($insert) {
                DataLokasi::insert($insert);
            }
        }

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.data.data-bencana.index')->with($notification);
    }

    public function destroy($id)
    {
        $dataBencanaDelete = DataBencana::find($id);
        if ($dataBencanaDelete) {
            $data['is_deleted'] = 1;
            $data['deleted_by'] = Auth::guard('admin')->user()->id;
            $data['deleted_at'] = date("Y-m-d H:i:s", strtotime('now'));

            $dataBencanaDelete->fill($data)->save();
        }
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
