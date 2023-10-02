<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('dashboard.settings', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        $setting = Setting::first();
        if($setting) $setting->update($request->all()); else Setting::create($request->all());
        return redirect()->back()->with('success', 'Contact information successfully updated.');
    }


}
