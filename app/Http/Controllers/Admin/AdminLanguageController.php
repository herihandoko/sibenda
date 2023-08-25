<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminLanguageController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:admin-language-index|admin-language-create|admin-language-edit|admin-language-delete', ['only' => ['index','show']]);
         $this->middleware('permission:admin-language-create', ['only' => ['create','store']]);
         $this->middleware('permission:admin-language-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:admin-language-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $language = require resource_path('lang/en/admin.php');
        return view('admin.adminLanguage', compact('language'));
    }
    public function update(Request $request)
    {
        $var = $request->except(['_token', '_method']);
        $var = collect($var)
            ->keys()
            ->map(function ($key) {
                return str_replace('_', ' ', $key);
            })
            ->combine($var);
        $modifiedData = var_export($var->toArray(), true);
        file_put_contents(resource_path('lang/en/admin.php'), "<?php\n return {$modifiedData};\n ?>");

        $notification = trans('admin.Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];
        return redirect()->route('admin.admin-language.index')->with($notification);


    }
}
