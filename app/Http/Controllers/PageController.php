<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($subdomain, $id)
    {
        $pages = auth()->user()->pages->pluck('id')->toArray();
        $page = Page::findOrFail($id);
        if(in_array($id, $pages)) return view('page', compact('page'));
        abort(404);
    }
}
