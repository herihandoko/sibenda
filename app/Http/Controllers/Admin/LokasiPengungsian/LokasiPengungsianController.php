<?php

namespace App\Http\Controllers\Admin\LokasiPengungsian;

use App\DataTables\LokasiPengungsian\LokasiPengungsianDataTable;
use App\Http\Controllers\Controller;
use App\Models\LokasiPengungsian\LokasiPengungsian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class LokasiPengungsianController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:lokasi-pengungsian-index|lokasi-pengungsian-create|lokasi-pengungsian-edit|lokasi-pengungsian-delete', ['only' => ['index','show']]);
         $this->middleware('permission:lokasi-pengungsian-create', ['only' => ['create','store']]);
         $this->middleware('permission:lokasi-pengungsian-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:lokasi-pengungsian-delete', ['only' => ['destroy']]);
    }

    public function index(LokasiPengungsianDataTable $lokasiPengungsianDataTable)
    {
        return $lokasiPengungsianDataTable->render('admin.lokasipengungsian.lokasiPengungsianIndex');
    }
    
    public function create()
    {
        return view('admin.lokasipengungsian.lokasiPengungsianCreate');
    }
    
    public function store(Request $request)
    {
        $rules = [
            'id_databencana' => 'required',
            'jenis_hunian_id' => 'required',
            'kapasitas' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
        ];

        $customMessages = [
            'jenis_hunian_id.required' => trans('Jenis Hunian belum dipilih'),
        ];

        $this->validate($request, $rules, $customMessages);

        $lokasiPengungsian = new LokasiPengungsian();
        $lokasiPengungsian->id_databencana = $request->id_databencana;
        $lokasiPengungsian->jenis_hunian_id = $request->jenis_hunian_id;
        $lokasiPengungsian->kapasitas = $request->kapasitas;
        $lokasiPengungsian->alamat = $request->alamat;
        $lokasiPengungsian->provinsi = $request->provinsi;
        $lokasiPengungsian->kabupaten = $request->kabupaten;
        $lokasiPengungsian->kecamatan = $request->kecamatan;
        $lokasiPengungsian->kelurahan = $request->kelurahan;
        $lokasiPengungsian->rt = $request->rt;
        $lokasiPengungsian->rw = $request->rw;
        $lokasiPengungsian->keterangan = $request->keterangan;
        $lokasiPengungsian->created_by = Auth::guard('admin')->user()->id;
        $lokasiPengungsian->save();

        $notification = trans('admin.Created Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.data.lokasi-pengungsian.index')->with($notification);
    }
    
    public function edit($id)
    {
        $lokasiPengungsian = LokasiPengungsian::find($id);
        return view('admin.lokasipengungsian.lokasiPengungsianEdit', compact('lokasiPengungsian'));
    }
    
    public function update(Request $request, $id)
    {
        $rules = [
            'jenis_hunian_id' => 'required',
            'kapasitas' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
        ];

        $customMessages = [
            'jenis_hunian_id.required' => trans('Jenis Hunian belum dipilih'),
        ];

        $this->validate($request, $rules, $customMessages);

        $lokasiPengungsian = LokasiPengungsian::findOrFail($id);
        $lokasiPengungsian->id_databencana = $request->id_databencana;
        $lokasiPengungsian->jenis_hunian_id = $request->jenis_hunian_id;
        $lokasiPengungsian->kapasitas = $request->kapasitas;
        $lokasiPengungsian->alamat = $request->alamat;
        $lokasiPengungsian->provinsi = $request->provinsi;
        $lokasiPengungsian->kabupaten = $request->kabupaten;
        $lokasiPengungsian->kecamatan = $request->kecamatan;
        $lokasiPengungsian->kelurahan = $request->kelurahan;
        $lokasiPengungsian->rt = $request->rt;
        $lokasiPengungsian->rw = $request->rw;
        $lokasiPengungsian->keterangan = $request->keterangan;
        $lokasiPengungsian->updated_by = Auth::guard('admin')->user()->id;
        $lokasiPengungsian->save();

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.data.lokasi-pengungsian.index')->with($notification);
    }
    
    public function destroy($id)
    {
        $lokasiPengungsianDelete = LokasiPengungsian::find($id);
        if($lokasiPengungsianDelete) {
            $data['is_deleted'] = 1;
            $data['deleted_by'] = Auth::guard('admin')->user()->id;
            $data['deleted_at'] = date("Y-m-d H:i:s", strtotime('now'));

            $lokasiPengungsianDelete->fill($data)->save();
        }
    }
}