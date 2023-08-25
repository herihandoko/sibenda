<?php

namespace App\Http\Controllers\Admin\Master;

use App\DataTables\Master\KategoriKorbanDataTable;
use App\Http\Controllers\Controller;
use App\Models\Master\KategoriKorban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class KategoriKorbanController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:kategori-korban-index|kategori-korban-create|kategori-korban-edit|kategori-korban-delete', ['only' => ['index','show']]);
         $this->middleware('permission:kategori-korban-create', ['only' => ['create','store']]);
         $this->middleware('permission:kategori-korban-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kategori-korban-delete', ['only' => ['destroy']]);
    }

    public function index(KategoriKorbanDataTable $kategoriKorbanDataTable)
    {
        return $kategoriKorbanDataTable->render('admin.master.kategoriKorbanIndex');
    }
    
    public function create()
    {
        return view('admin.master.kategoriKorbanCreate');
    }
    
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:m_kategori_korban',
        ];

        $customMessages = [
            'name.required' => trans('Nama tidak boleh kosong'),
            'name.unique' => trans('Nama sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $kategoriKorban = new KategoriKorban();
        $kategoriKorban->name = $request->name;
        $kategoriKorban->created_by = Auth::guard('admin')->user()->id;
        $kategoriKorban->save();


        $notification = trans('admin.Created Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.master.kategori-korban.index')->with($notification);
    }
    
    public function edit($id)
    {
        $kategoriKorban = KategoriKorban::find($id);
        return view('admin.master.kategoriKorbanEdit', compact('kategoriKorban'));
    }
    
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:m_kategori_korban,name,' . $id,
        ];

        $customMessages = [
            'name.required' => trans('Nama tidak boleh kosong'),
            'name.unique' => trans('Nama sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $kategoriKorban = KategoriKorban::findOrFail($id);
        $kategoriKorban->name = $request->name;
        $kategoriKorban->updated_by = Auth::guard('admin')->user()->id;
        $kategoriKorban->save();

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.master.kategori-korban.index')->with($notification);
    }
    
    public function destroy($id)
    {
        $catKorbanDelete = KategoriKorban::find($id);
        if($catKorbanDelete) {
            $data['is_deleted'] = 1;
            $data['deleted_by'] = Auth::guard('admin')->user()->id;
            $data['deleted_at'] = date("Y-m-d H:i:s", strtotime('now'));

            $catKorbanDelete->fill($data)->save();
        }
    }
}