<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function index()
    {
        $news = Page::where('category', 'news')->whereNotIn('id', $this->ids())->orderBy('id', 'desc')->get();
        return view('news', compact('news'));
    }

    public function show($id)
    {
        if(in_array($id, $this->ids())) abort(404);
        $news = Page::findOrFail($id);
        return view('newsShow', compact('news'));
    }

    public function ids()
    {
        return DB::table('page_user')->distinct()->pluck('page_id')->toArray();
    }
}
