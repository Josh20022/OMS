<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function profile($subdomain)
    {
        $user = auth()->user();
        $forms = $user->forms->where('publish', true)->pluck('title', 'id')->toArray();
        if (isset($user->parents)){
        $documentationOrder = $user->parents->documentationOrder;
        $registrationOrder = $user->parents->registrationOrder;
        $reportOrder = $user->parents->reportOrder;
        $formOrder = $user->parents->formOrder;
        } else {
        $documentationOrder = $user->documentationOrder;
        $registrationOrder = $user->registrationOrder;
        $reportOrder = $user->reportOrder;
        $formOrder = $user->formOrder;
        }
        $filteredForms = $documentations = $registrations = $reports = [];
        $documentations = ($documentationOrder) ? arrayKeyAdjust($documentationOrder->ids) : $this->createPagesArray($user->documentationPages);
        $registrations = ($registrationOrder) ? arrayKeyAdjust($registrationOrder->ids) : $this->createPagesArray($user->registrationPages);
        $reports = ($reportOrder) ? arrayKeyAdjust($reportOrder->ids) : $this->createPagesArray($user->reportPages);
        $filteredForms = ($formOrder) ? array_intersect_key(arrayKeyAdjust($formOrder->ids), $forms) : $forms;
        return view('profile', compact('user', 'filteredForms', 'documentations', 'registrations', 'reports'));
    }

    public function update($subdomain, Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'avatar' => 'image',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if($request->password) $data['password'] = Hash::make($request->password);

        if($request->_remove_avatar == 'remove_avatar') {
            Storage::delete($user->avatar);
            $data['avatar'] = NULL;
        } elseif($request->hasFile('avatar')) {
            Storage::delete($user->avatar);
            $folder = date('Y-m');
            $data['avatar'] = $request->file('avatar')->store("{$folder}");
        }

        $user->update($data);
        User::where('company', $user->id)->update(['avatar' => $user->avatar]);
        return redirect()->back()->with('success', 'Profile updated.');
    }

    private function createPagesArray($pages)
    {
        $pageArray = [];
        foreach($pages as $page) {
            $pageArray[$page->id] = $page->title;
            $children = $page->children->pluck('title', 'id')->toArray();
            foreach($children as $id => $title) $pageArray[$id] = $title;
        }

        return $pageArray;
    }
}
