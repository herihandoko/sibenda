<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\OrderDataTable;
use App\DataTables\TransactionDataTable;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserAdress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class UserPanelController extends Controller
{
    public  function dashboard()
    {
        $orders = Auth::user()->orders()->latest()->paginate(5);

        return view('frontend.ordersIndex', compact('orders'));
    }
    public  function transactions()
    {
        $transactions = Auth::user()->transactions()->latest()->paginate(5);
        return view('frontend.transactionsIndex', compact('transactions'));
    }
    public  function profile()
    {
        $user = Auth::user();
        return view('frontend.profileIndex', compact('user'));
    }
    public function update_profile(Request $request)
    {





        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required',
            'post_code' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('name')) {
                toast(trans('frontend.Name required!'), 'error')->width('300px');
                return redirect()->back()->withInput();
            }
            if ($validator->errors()->has('phone')) {
                toast(trans('frontend.Phone required!'), 'error')->width('300px');
                return redirect()->back()->withInput();
            }
            if ($validator->errors()->has('country')) {
                toast(trans('frontend.Country required!'), 'error')->width('300px');
                return redirect()->back()->withInput();
            }
            if ($validator->errors()->has('city')) {
                toast(trans('frontend.City required!'), 'error')->width('300px');
                return redirect()->back()->withInput();
            }
            if ($validator->errors()->has('post_code')) {
                toast(trans('frontend.Post code required!'), 'error')->width('300px');
                return redirect()->back()->withInput();
            }
            if ($validator->errors()->has('address')) {
                toast(trans('frontend.Address required!'), 'error')->width('300px');
                return redirect()->back()->withInput();
            }
        }

        if (strlen($request->password) > 0) {
            if (strlen($request->password) < 4) {
                toast(trans('frontend.Password must be min 4 charecters!'), 'error')->width('350px');
                return redirect()->back()->withInput();
            }

            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($request->password);
            $user->save();

            toast(trans('frontend.Password changed successfully!'), 'success')->width('350px');
            return redirect()->back()->withInput();
        }


        $user = User::find(Auth::user()->id);

        if ($request->hasFile('avatar')) {

            if(File::exists(public_path("$user->avatar"))){
                File::delete(public_path("$user->avatar"));
            }

            // Upload Avatar
            $image = $request->file('avatar');
            $name = 'media_' . time();
            $avatar_folder = 'assets/uploads/user/avatar/';

            if(!File::isDirectory(public_path($avatar_folder))){
                File::makeDirectory(public_path($avatar_folder), 0777, true, true);

            }

            $avatar_path = $avatar_folder . $name . '.' . $image->getClientOriginalExtension();

            //Resize Avatar
            $avatar = Image::make($image);
            $avatar->fit(400, 400);
            $avatar->save(public_path($avatar_path));
            // Insert Data
            $user->avatar = $avatar_path;
        }

        $user->name = $request->name ?: $user->name;
        $user->phone = $request->phone ?: $user->phone;

        $user->save();
        if (!UserAdress::where(['user_id' => $user->id])->first()) $address = new UserAdress();
        else $address = UserAdress::where(['user_id' => $user->id])->first();
        $address->user_id = $user->id;
        $address->country = $request->country;
        $address->city = $request->city;
        $address->post_code = $request->post_code;
        $address->address = $request->address;
        $address->save();

        toast(trans('frontend.Profile Updated!'), 'success')->width('350px');

        return redirect()->back();
    }

    public function shipping_address(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'country' => 'required',
            'city' => 'required',
            'post_code' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('country')) {
                toast(trans('frontend.Country required!'), 'error')->width('300px');
                return redirect()->back()->withInput();
            }
            if ($validator->errors()->has('city')) {
                toast(trans('frontend.City required!'), 'error')->width('300px');
                return redirect()->back()->withInput();
            }
            if ($validator->errors()->has('post_code')) {
                toast(trans('frontend.Post code required!'), 'error')->width('300px');
                return redirect()->back()->withInput();
            }
            if ($validator->errors()->has('address')) {
                toast(trans('frontend.Address required!'), 'error')->width('300px');
                return redirect()->back()->withInput();
            }
        }


        $user = User::find(Auth::user()->id);
        $user->name = $request->name ?: $user->name;
        $user->phone = $request->phone ?: $user->phone;
        $user->save();
        if (!UserAdress::where(['user_id' => $user->id])->first()) $address = new UserAdress();
        else $address = UserAdress::where(['user_id' => $user->id])->first();
        $address->user_id = $user->id;
        $address->country = $request->country;
        $address->city = $request->city;
        $address->post_code = $request->post_code;
        $address->address = $request->address;
        $address->save();
        toast(trans('frontend.Address Updated!'), 'success')->width('300px');
        return redirect()->back();
    }
}
