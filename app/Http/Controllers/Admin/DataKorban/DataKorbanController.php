<?php

namespace App\Http\Controllers\Admin\DataKorban;

use App\DataTables\DataKorban\DataKorbanDataTable;
use App\Http\Controllers\Controller;
use App\Models\DataKorban\DataKorban;
use App\Models\Master\StatusKorban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;

class DataKorbanController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:data-korban-index|data-korban-create|data-korban-edit|data-korban-delete', ['only' => ['index','show']]);
         $this->middleware('permission:data-korban-create', ['only' => ['create','store']]);
         $this->middleware('permission:data-korban-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:data-korban-delete', ['only' => ['destroy']]);
    }

    public function index(DataKorbanDataTable $dataKorbanDataTable)
    {
        return $dataKorbanDataTable->render('admin.datakorban.dataKorbanIndex');
    }
    
    public function create()
    {
        return view('admin.datakorban.dataKorbanCreate');
    }
    
    public function store(Request $request)
    {
        $rules = [
            'id_databencana' => 'required',
            'nama_korban' => 'required',
            'nik' => 'required',
            'jns_kelamin' => 'required',
            'tgl_lahir' => 'required',
            'kategori_korban_id' => 'required',
            'status_korban_id' => 'required',
        ];

        $customMessages = [
            'nama_korban.required' => trans('Nama Korban belum diisi'),
        ];

        $this->validate($request, $rules, $customMessages);

        $dataKorban = new DataKorban();
        $dataKorban->id_databencana = $request->id_databencana;
        $dataKorban->nama_korban = $request->nama_korban;
        $dataKorban->nik = $request->nik;
        $dataKorban->jns_kelamin = $request->jns_kelamin;
        $dataKorban->tgl_lahir = $request->tgl_lahir;
        $dataKorban->usia = $request->usia;
        $dataKorban->kategori_korban_id = $request->kategori_korban_id;
        $dataKorban->status_korban_id = $request->status_korban_id;
        $dataKorban->mengungsi = $request->mengungsi;
        $dataKorban->lokasi_pengungsian_id = $request->lokasi_pengungsian_id;
        $dataKorban->disabilitas = $request->disabilitas;
        $dataKorban->hamil = $request->hamil;
        $dataKorban->usia_hamil = $request->usia_hamil;
        $dataKorban->jenis_hamil = $request->jenis_hamil;
        $dataKorban->menyusui = $request->menyusui;
        $dataKorban->alamat = $request->alamat;
        $dataKorban->provinsi = $request->provinsi;
        $dataKorban->kabupaten = $request->kabupaten;
        $dataKorban->kecamatan = $request->kecamatan;
        $dataKorban->kelurahan = $request->kelurahan;
        $dataKorban->rt = $request->rt;
        $dataKorban->rw = $request->rw;
        $dataKorban->alamat_rs = $request->alamat_rs;
        $dataKorban->lokasi_hilang = $request->lokasi_hilang;
        $dataKorban->ahli_waris = $request->ahli_waris;
        $dataKorban->keterangan = $request->keterangan;
        $dataKorban->created_by = Auth::guard('admin')->user()->id;
        $dataKorban->save();

        $notification = trans('admin.Created Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.data.data-korban.index')->with($notification);
    }
    
    public function edit($id)
    {
        $dataKorban = DataKorban::find($id);
        return view('admin.datakorban.dataKorbanEdit', compact('dataKorban'));
    }
    
    public function update(Request $request, $id)
    {
        $rules = [
            'id_databencana' => 'required',
            'nama_korban' => 'required',
            'nik' => 'required',
            'jns_kelamin' => 'required',
            'tgl_lahir' => 'required',
            'kategori_korban_id' => 'required',
            'status_korban_id' => 'required',
        ];

        $customMessages = [
            'nama_korban.required' => trans('Nama Korban belum diisi'),
        ];

        $this->validate($request, $rules, $customMessages);

        $dataKorban = DataKorban::findOrFail($id);
        $dataKorban->id_databencana = $request->id_databencana;
        $dataKorban->nama_korban = $request->nama_korban;
        $dataKorban->nik = $request->nik;
        $dataKorban->jns_kelamin = $request->jns_kelamin;
        $dataKorban->tgl_lahir = $request->tgl_lahir;
        $dataKorban->usia = $request->usia;
        $dataKorban->kategori_korban_id = $request->kategori_korban_id;
        $dataKorban->status_korban_id = $request->status_korban_id;
        $dataKorban->mengungsi = $request->mengungsi;
        $dataKorban->lokasi_pengungsian_id = $request->lokasi_pengungsian_id;
        $dataKorban->disabilitas = $request->disabilitas;
        $dataKorban->hamil = $request->hamil;
        $dataKorban->usia_hamil = $request->usia_hamil;
        $dataKorban->jenis_hamil = $request->jenis_hamil;
        $dataKorban->menyusui = $request->menyusui;
        $dataKorban->alamat = $request->alamat;
        $dataKorban->provinsi = $request->provinsi;
        $dataKorban->kabupaten = $request->kabupaten;
        $dataKorban->kecamatan = $request->kecamatan;
        $dataKorban->kelurahan = $request->kelurahan;
        $dataKorban->rt = $request->rt;
        $dataKorban->rw = $request->rw;
        $dataKorban->alamat_rs = $request->alamat_rs;
        $dataKorban->lokasi_hilang = $request->lokasi_hilang;
        $dataKorban->ahli_waris = $request->ahli_waris;
        $dataKorban->keterangan = $request->keterangan;
        $dataKorban->updated_by = Auth::guard('admin')->user()->id;
        $dataKorban->save();

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.data.data-korban.index')->with($notification);
    }
    
    public function destroy($id)
    {
        $dataKorbanDelete = DataKorban::find($id);
        if($dataKorbanDelete) {
            $data['is_deleted'] = 1;
            $data['deleted_by'] = Auth::guard('admin')->user()->id;
            $data['deleted_at'] = date("Y-m-d H:i:s", strtotime('now'));

            $dataKorbanDelete->fill($data)->save();
        }
    }
    
    public function getName(Request $request) {
        $name = StatusKorban::select('name')->where('id', $request->id)->first();
        return $name;
    }
    
     public function getBirthdate(Request $request) {
        $birthdate = Carbon::parse($request->tgl_lahir)->age;
        return $birthdate;
    }
}