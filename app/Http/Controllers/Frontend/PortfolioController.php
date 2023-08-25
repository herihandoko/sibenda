<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function portfolio(Request $request)
    {
        $portfolio = Portfolio::where(['slug' => $request->slug])->first();
        return view('frontend.portfolio', compact('portfolio'));
    }
}
