<?php

namespace App\Http\Controllers\Admin\Master;

use App\DataTables\Master\JalurKomunikasiDataTable;
use App\Http\Controllers\Controller;
use App\Models\Master\JalurKomunikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class JalurKomunikasiController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:jalur-komunikasi-index|jalur-komunikasi-create|jalur-komunikasi-edit|jalur-komunikasi-delete', ['only' => ['index','show']]);
         $this->middleware('permission:jalur-komunikasi-create', ['only' => ['create','store']]);
         $this->middleware('permission:jalur-komunikasi-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:jalur-komunikasi-delete', ['only' => ['destroy']]);
    }

    public function index(JalurKomunikasiDataTable $jalurKomunikasiDataTable)
    {
        return $jalurKomunikasiDataTable->render('admin.master.jalurKomunikasiIndex');
    }
    
    public function create()
    {
        return view('admin.master.jalurKomunikasiCreate');
    }
    
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:m_jalur_komunikasi',
        ];

        $customMessages = [
            'name.required' => trans('Nama tidak boleh kosong'),
            'name.unique' => trans('Nama sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $jalurKomunikasi = new JalurKomunikasi();
        $jalurKomunikasi->name = $request->name;
        $jalurKomunikasi->created_by = Auth::guard('admin')->user()->id;
        $jalurKomunikasi->save();


        $notification = trans('admin.Created Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.master.jalur-komunikasi.index')->with($notification);
    }
    
    public function edit($id)
    {
        $jalurKomunikasi = JalurKomunikasi::find($id);
        return view('admin.master.jalurKomunikasiEdit', compact('jalurKomunikasi'));
    }
    
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:m_jalur_komunikasi,name,' . $id,
        ];

        $customMessages = [
            'name.required' => trans('Nama tidak boleh kosong'),
            'name.unique' => trans('Nama sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $jalurKomunikasi = JalurKomunikasi::findOrFail($id);
        $jalurKomunikasi->name = $request->name;
        $jalurKomunikasi->updated_by = Auth::guard('admin')->user()->id;
        $jalurKomunikasi->save();

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.master.jalur-komunikasi.index')->with($notification);
    }
    
    public function destroy($id)
    {
        $jlrKomunikasiDelete = JalurKomunikasi::find($id);
        if($jlrKomunikasiDelete) {
            $data['is_deleted'] = 1;
            $data['deleted_by'] = Auth::guard('admin')->user()->id;
            $data['deleted_at'] = date("Y-m-d H:i:s", strtotime('now'));

            $jlrKomunikasiDelete->fill($data)->save();
        }
    }
}