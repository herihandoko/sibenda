<?php

namespace App\Http\Controllers\Admin\Master;

use App\DataTables\Master\JenisHunianDataTable;
use App\Http\Controllers\Controller;
use App\Models\Master\JenisHunian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class JenisHunianController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:jenis-hunian-index|jenis-hunian-create|jenis-hunian-edit|jenis-hunian-delete', ['only' => ['index','show']]);
         $this->middleware('permission:jenis-hunian-create', ['only' => ['create','store']]);
         $this->middleware('permission:jenis-hunian-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:jenis-hunian-delete', ['only' => ['destroy']]);
    }

    public function index(JenisHunianDataTable $jenisHunianDataTable)
    {
        return $jenisHunianDataTable->render('admin.master.jenisHunianIndex');
    }
    
    public function create()
    {
        return view('admin.master.jenisHunianCreate');
    }
    
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:m_jenis_hunian',
        ];

        $customMessages = [
            'name.required' => trans('Nama tidak boleh kosong'),
            'name.unique' => trans('Nama sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $jenisHunian = new JenisHunian();
        $jenisHunian->name = $request->name;
        $jenisHunian->created_by = Auth::guard('admin')->user()->id;
        $jenisHunian->save();


        $notification = trans('admin.Created Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.master.jenis-hunian.index')->with($notification);
    }
    
    public function edit($id)
    {
        $jenisHunian = JenisHunian::find($id);
        return view('admin.master.jenisHunianEdit', compact('jenisHunian'));
    }
    
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:m_jenis_hunian,name,' . $id,
        ];

        $customMessages = [
            'name.required' => trans('Nama tidak boleh kosong'),
            'name.unique' => trans('Nama sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $jenisHunian = JenisHunian::findOrFail($id);
        $jenisHunian->name = $request->name;
        $jenisHunian->updated_by = Auth::guard('admin')->user()->id;
        $jenisHunian->save();

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.master.jenis-hunian.index')->with($notification);
    }
    
    public function destroy($id)
    {
        $jnsHunianDelete = JenisHunian::find($id);
        if($jnsHunianDelete) {
            $data['is_deleted'] = 1;
            $data['deleted_by'] = Auth::guard('admin')->user()->id;
            $data['deleted_at'] = date("Y-m-d H:i:s", strtotime('now'));

            $jnsHunianDelete->fill($data)->save();
        }
    }
}