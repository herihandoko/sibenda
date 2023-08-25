<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PageBuilder;
use Illuminate\Http\Request;

class DynamicPageController extends Controller
{
    public function index()
    {
        $page = PageBuilder::where(['slug' => 'home'])->firstOrFail();
        $elements = explode(',', $page->contents);
        return view('frontend.dynamicPage', compact('elements', 'page'));
    }
    public function page($slug)
    {
        $page = PageBuilder::where(['slug' => $slug])->firstOrFail();
        $elements = explode(',', $page->contents);
        return view('frontend.dynamicPage', compact('elements', 'page'));
    }
}
