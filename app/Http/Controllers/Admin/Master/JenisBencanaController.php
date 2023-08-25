<?php

namespace App\Http\Controllers\Admin\Master;

use App\DataTables\Master\JenisBencanaDataTable;
use App\Http\Controllers\Controller;
use App\Models\Master\JenisBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class JenisBencanaController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:jenis-bencana-index|jenis-bencana-create|jenis-bencana-edit|jenis-bencana-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:jenis-bencana-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:jenis-bencana-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:jenis-bencana-delete', ['only' => ['destroy']]);
    }

    public function index(JenisBencanaDataTable $jenisBencanaDataTable)
    {
        return $jenisBencanaDataTable->render('admin.master.jenisBencanaIndex');
    }

    public function create()
    {
        return view('admin.master.jenisBencanaCreate');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:m_jenis_bencana',
            'icon' => 'required',
        ];

        $customMessages = [
            'name.required' => trans('Nama tidak boleh kosong'),
            'name.unique' => trans('Nama sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $jenisBencana = new JenisBencana();
        $jenisBencana->name = $request->name;
        $jenisBencana->icon = $request->icon;
        $jenisBencana->created_by = Auth::guard('admin')->user()->id;
        $jenisBencana->save();


        $notification = trans('admin.Created Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.master.jenis-bencana.index')->with($notification);
    }

    public function edit($id)
    {
        $jenisBencana = JenisBencana::find($id);
        return view('admin.master.jenisBencanaEdit', compact('jenisBencana'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:m_jenis_bencana,name,' . $id,
            'icon' => 'required',
        ];

        $customMessages = [
            'name.required' => trans('Nama tidak boleh kosong'),
            'name.unique' => trans('Nama sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $jenisBencana = JenisBencana::findOrFail($id);
        $jenisBencana->name = $request->name;
        $jenisBencana->icon = $request->icon;
        $jenisBencana->updated_by = Auth::guard('admin')->user()->id;
        $jenisBencana->save();

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.master.jenis-bencana.index')->with($notification);
    }

    public function destroy($id)
    {
        $jnsBencanaDelete = JenisBencana::find($id);
        if ($jnsBencanaDelete) {
            $data['is_deleted'] = 1;
            $data['deleted_by'] = Auth::guard('admin')->user()->id;
            $data['deleted_at'] = date("Y-m-d H:i:s", strtotime('now'));

            $jnsBencanaDelete->fill($data)->save();
        }
    }

    public function getName(Request $request)
    {
        $name = JenisBencana::select('name')->where('id', $request->id)->first();
        return $name;
    }
}
