<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Page;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        if(auth()->user()->type == 'admin') {
            $pages = Page::count();
            $forms = Form::count();
            $clients = User::where('type', 'client')->count();
            $users = User::where('type', 'user')->count();
            return view('dashboard.dashboard', compact('clients', 'users', 'forms', 'pages'));
        }

        return redirect()->route('clients.show', auth()->id());
    }
}
