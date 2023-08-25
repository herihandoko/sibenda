<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ShippingCountry;
use App\Models\ShopSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cart;

class ShopController extends Controller
{
    public function index()
    {
        return view('frontend.shopIndex');
    }
    public function product($slug)
    {
        $product = Product::where(['slug' => $slug])->firstOrFail();
        return view('frontend.productIndex', compact('product'));
    }
    public function cart()
    {
        if (Cart::content()->count() == 0) {
            alert()->info(trans('frontend.Your cart is empty!'), trans('frontend.Please add items to cart!'));
            return redirect()->back();
        }
        $user = Auth::user();
        if (!Auth::user()->address) {
            alert()->info(trans('frontend.Address missing!'), trans('frontend.Please fill up your shipping address before checkout.'));
        }
        return view('frontend.cartIndex', compact('user'));
    }
    public function cart_fetch()
    {
        return view('frontend.layouts.manuCart')->render();
    }
    public function cart_page(Request $request)
    {
        $shipping_fee = @ShippingCountry::where(['country' => $request->country])->first()->shipping_fee ?: ShopSetting::first()->default_shipping_fee;
        $user = Auth::user();
        return view('frontend.layouts.cart_ajax', compact('user', 'shipping_fee'))->render();
    }
    public function review(Request $request)
    {
        $review = new ProductReview();
        $review->rating = $request->rating == null ? 1 : $request->rating;
        $review->comment = $request->comment;
        $review->status = 0;
        $review->user_id = Auth::user()->id;
        $review->product_id = $request->id;
        $review->save();

        toast(trans('frontend.Review added!'), 'success')->width('350px');

        return redirect()->back();
    }
    public function product_quickview(Request $request)
    {
        $product = Product::where(['slug' => request()->get('product')])->firstOrFail();
        return view('frontend.productQuickview', compact('product'))->render();
    }
}
