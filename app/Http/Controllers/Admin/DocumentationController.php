<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DocumentationDataTable;
use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DocumentationController extends Controller
{
    //
    public function index(DocumentationDataTable $statusKorbanDataTable)
    {
        return $statusKorbanDataTable->render('admin.documentation.dokumentasiIndex');
    }

    public function create()
    {
        return view('admin.documentation.dokumentasiCreate');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|unique:dokumentasi|min:3|max:500',
            'tanggal' => 'required|date_format:Y-m-d|before:tomorrow',
            'description' => 'max:4000',
            'image_1' => 'required|max:500',
        ];

        $customMessages = [
            'title.required' => trans('Judul tidak boleh kosong'),
            'title.unique' => trans('Judul sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->except(['_token']);
        $data['slug'] = Str::slug($request->title);
        $data['created_by'] = Auth::guard('admin')->user()->id;
        $data['status'] = 1;
        Dokumentasi::create($data);

        $notification = trans('admin.Created Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.documentation')->with($notification);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|min:3|max:500|unique:dokumentasi,title,' . $id,
            'tanggal' => 'required|date_format:Y-m-d|before:tomorrow',
            'description' => 'max:4000',
            'image_1' => 'required|max:500',
        ];

        $customMessages = [
            'title.required' => trans('Judul tidak boleh kosong'),
            'title.unique' => trans('Judul sudah ada'),
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->except(['_token']);
        $data['slug'] = Str::slug($request->title);
        $data['created_by'] = Auth::guard('admin')->user()->id;
        $data['status'] = 1;
        Dokumentasi::where('id', $id)->update($data);

        $notification = trans('admin.Update Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.documentation')->with($notification);
    }

    public function destroy($id)
    {
        Dokumentasi::where('id', $id)->delete();
    }

    public function edit($id)
    {
        $dokumentasi = Dokumentasi::find($id);
        return view('admin.documentation.dokumentasiEdit', compact('dokumentasi'));
    }
}
