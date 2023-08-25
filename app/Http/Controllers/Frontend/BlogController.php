<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where(['status' => 1])
            ->paginate(GetSetting('blog_pagination'));
        return view('frontend.blogIndex', compact('blogs'));
    }
    public function show($slug)
    {
        $blog = Blog::where(['slug' => $slug, 'status' => 1])->firstOrFail();
        return view('frontend.blogSingle', compact('blog'));
    }
    public function search(Request $request)
    {
        $search = $request->get('query');
        $blogs = Blog::where(['status' => 1])
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->paginate(GetSetting('blog_search_pagination'));
        return view('frontend.blogSearch', compact('blogs'));
    }
    public function archive(Request $request)
    {
        $blogs = Blog::where(['status' => 1])
            ->where('created_at', 'LIKE', "%{$request->range}%")
            ->paginate(GetSetting('blog_archive_pagination'));
        return view('frontend.blogArchive', compact('blogs'));
    }
    public function search_tag(Request $request)
    {
        $blogs = Blog::where(['status' => 1])->select("blogs.*")
            ->whereRaw("find_in_set('" . $request->tag . "',blogs.tags)")
            ->paginate(GetSetting('blog_tag_search_pagination'));
        return view('frontend.blogTag', compact('blogs'));
    }
    public function category(Request $request)
    {
        $blogs = BlogCategory::where('slug', $request->slug)
            ->firstOrFail()
            ->getBlogs()
            ->where(['status' => 1])
            ->paginate(GetSetting('blog_category_pagination'));
        return view('frontend.blogCategory', compact('blogs'));
    }
    public function comment(Request $request)
    {
        $comment = new BlogComment();
        $comment->blog_id  = $request->blog;
        $comment->name    = $request->name;
        $comment->email   = $request->email;
        $comment->phone = $request->phone;
        $comment->status  = 0;
        $comment->comment = $request->comment;
        $comment->save();


        toast(trans('frontend.Comment added!'), 'success')->width('350px');
        return redirect()->back();
    }
}
