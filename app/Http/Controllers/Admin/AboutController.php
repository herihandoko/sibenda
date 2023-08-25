<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class AboutController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:about-index|about-create|about-edit|about-delete', ['only' => ['index','show']]);
         $this->middleware('permission:about-create', ['only' => ['create','store']]);
         $this->middleware('permission:about-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:about-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = About::first();
        return view('admin.aboutIndex', compact('about'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $about = About::first();
        if (!$about) {
            $about = new About();
        }


        $rules = [
            'description' => 'required',
            'bottom_text' => 'required',
        ];

        $customMessages = [
            'description.required' => trans('admin.Description is required'),
            'bottom_text.required' => trans('admin.Bottom Text is required'),
        ];

        $this->validate($request, $rules, $customMessages);


        $about->background = $request->background;
        $about->foreground = $request->foreground;
        $about->avatar = $request->avatar;
        $about->signature = $request->signature;
        $about->title = $request->title;
        $about->subtitle = $request->subtitle;
        $about->description = $request->description;
        $about->bottom_text = $request->bottom_text;
        $about->save();

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.about.index')->with($notification);
    }
}
