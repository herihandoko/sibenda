<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class MediaManagerController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:media-manager-index|media-manager-create|media-manager-edit|media-manager-delete', ['only' => ['index','show']]);
         $this->middleware('permission:media-manager-create', ['only' => ['create','store']]);
         $this->middleware('permission:media-manager-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:media-manager-delete', ['only' => ['destroy']]);
    }


    public function showmanager()
    {
        return view('admin.mediaManager');
    }
    // Show All Files
    public function index()
    {
        $data = Media::paginate(8);
        return view('pagination', compact('data'));
    }
    // Ajax Fetch All Files
    public function images(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $data = Media::where('file_path', 'like', '%' . $query . '%')
                ->orWhere('file_name', 'like', '%' . $query . '%')
                ->orderBy("id", "desc")
                ->paginate(8);
            return view('admin.layouts.media', compact('data'))->render();
        }
    }
    // Upload An Image
    public function upload(Request $request)
    {
        // Check image selected
        if (!$request->hasFile('image')) {
            return response([
                'img_status' => 'notselected',
            ]);
        }
        // Check image name
        if (!$request->name) {
            return response([
                'name_status' => 'missing',
            ]);
        }
        
        // Upload image
        if ($request->hasFile('image')) {
            // Upload File
            
            $image = $request->file('image');
            $name = 'media_' . time();
            $main_folder  = 'assets/uploads/images/';

            $main_path  = $main_folder .  $name . '.' . $image->getClientOriginalExtension();
            
            //Resize Big Image
            $main = Image::make($image);
            
            $main->save(public_path($main_path));
            
            // Insert Data
            Media::insert([
                'file_name' => $request->name,
                'file_path' => $main_path,
                'file_type' => 'image',
            ]);
            // Ajax Respose
            return response([
                'name_status' => 'exist',
                'img_status' => 'uploaded',
            ]);
        }
    }
    public function delete(Request $request)
    {
        $file = Media::find($request->id);
        File::delete(public_path($file->file_path));
        $file->delete();
        return response([
            'status' => 'deleted'
        ]);
    }
}
