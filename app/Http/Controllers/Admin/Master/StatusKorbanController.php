<?php

namespace App\Http\Controllers\Admin\Master;

use App\DataTables\Master\StatusKorbanDataTable;
use App\Http\Controllers\Controller;
use App\Models\Master\StatusKorban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class StatusKorbanController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:status-korban-index|status-korban-create|status-korban-edit|status-korban-delete', ['only' => ['index','show']]);
         $this->middleware('permission:status-korban-create', ['only' => ['create','store']]);
         $this->middleware('permission:status-korban-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:status-korban-delete', ['only' => ['destroy']]);
    }

    public function index(StatusKorbanDataTable $statusKorbanDataTable)
    {
        return $statusKorbanDataTable->render('admin.master.statusKorbanIndex');
    }
    
    public function create()
    {
        return view('admin.master.statusKorbanCreate');
    }
    
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:m_status_korban',
        ];

        $customMessages = [
            'name.required' => trans('Nama tidak boleh kosong'),
            'name.unique' => trans('Nama sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $statusKorban = new StatusKorban();
        $statusKorban->name = $request->name;
        $statusKorban->created_by = Auth::guard('admin')->user()->id;
        $statusKorban->save();


        $notification = trans('admin.Created Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.master.status-korban.index')->with($notification);
    }
    
    public function edit($id)
    {
        $statusKorban = StatusKorban::find($id);
        return view('admin.master.statusKorbanEdit', compact('statusKorban'));
    }
    
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:m_status_korban,name,' . $id,
        ];

        $customMessages = [
            'name.required' => trans('Nama tidak boleh kosong'),
            'name.unique' => trans('Nama sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $statusKorban =  StatusKorban::findOrFail($id);
        $statusKorban->name = $request->name;
        $statusKorban->updated_by = Auth::guard('admin')->user()->id;
        $statusKorban->save();

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.master.status-korban.index')->with($notification);
    }
    
    public function destroy($id)
    {
        $stsKorbanDelete = StatusKorban::find($id);
        if($stsKorbanDelete) {
            $data['is_deleted'] = 1;
            $data['deleted_by'] = Auth::guard('admin')->user()->id;
            $data['deleted_at'] = date("Y-m-d H:i:s", strtotime('now'));

            $stsKorbanDelete->fill($data)->save();
        }
    }
}