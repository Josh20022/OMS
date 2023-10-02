<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\CredentialsMail;
use App\Models\Data;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->isAdmin()) {
            $users = User::where('type', 'user')->orderBy('name')->paginate(10);
        } else {
            $users = User::where('company', auth()->id())->orderBy('name')->paginate(10);
        }

        return view('dashboard.users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = User::where('type', 'client')->orderBy('name')->get();
        return view('dashboard.users.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'subdomain' => 'required|unique:users',
            'company' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'user',
            'company' => $request->company,
            'subdomain' => $request->subdomain,
            'bg_color' => $request->bg_color,
            'text_color' => $request->text_color,
            'avatar' => User::find($request->company)->avatar,
            'welcome_text' => $request->welcome_text,
        ];

        $user = User::create($data);
        $loginUrl = getProtocol() . getDomain() . '/login';

        $credentials = "
            Your account on WE Management have successfully created.
            <hr>
            <div>
                URL: <a href='$loginUrl'>WE Management</a>
                <br>
                Login: $request->email
                <br>
                Password: $request->password
            </div>
        ";

        Mail::to($request->email)->send(new CredentialsMail($credentials));
        return redirect()->back()->with('success', 'User added and credentials sended.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        if(!$this->checkAccess($user)) abort('404');
        return view('dashboard.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        if(!$this->checkAccess($user)) abort('404');
        $clients = User::where('type', 'client')->orderBy('name')->get();
        return view('dashboard.users.edit', compact('user', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        $request->validate([
            'name' => 'required',
            'subdomain' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'company' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subdomain' => $request->subdomain,
            'company' => $request->company,
            'bg_color' => $request->bg_color,
            'text_color' => $request->text_color,
            'avatar' => User::find($request->company)->avatar,
            'welcome_text' => $request->welcome_text,
        ];

        $user->update($data);
        $loginUrl = getProtocol() . getDomain() . '/login';

        $credentials = "
            Your account on WE Management have updated.
            <hr>
            <div>
                URL: <a href='$loginUrl'>WE Management</a>
                <br>
                Login: $request->email
                <br>
                Password: <i>Your password</i>
            </div>
        ";

        Mail::to($request->email)->send(new CredentialsMail($credentials));
        return redirect()->route('users.index')->with('success', 'User info updated and credentials sended.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        $user->delete();
        $user->forms()->detach();
        $user->pages()->detach();
        Order::where('user_id', $user->id)->delete();
        Data::where('user_id', $user->id)->delete();
        $url =  url('') . '/dashboard/users';
        return response()->json(['status' => 'deleted', 'url' => $url]);
    }

    private function checkAccess($user)
    {
        if(!auth()->user()->isAdmin() && $user->company !== auth()->id()) return false;
        return true;
    }
}
