<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:user-profile-index|user-profile-create|user-profile-edit|user-profile-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-profile-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-profile-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-profile-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.userProfileIndex', compact('user'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Admin::find(Auth::user()->id);
        $user->avatar = $request->avatar;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            if ($request->password == $request->confirm_password) {
                $user->password = bcrypt($request->password);
            }
        }
        $user->save();

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->back()->with($notification);

    }
}
