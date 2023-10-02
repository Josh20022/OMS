<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function show($userId, $slug)
    {
        abort_if(!$this->checkAccess((int) $userId), 404);
        $file = Storage::disk('local')->get("/$userId/$slug");
        return response()->make($file, 200, ['content-type' => Storage::disk('local')->mimeType("/$userId/$slug")]);
    }

    private function checkAccess($userId)
    {
        $user = User::find($userId);
        if(auth()->user()->type == 'admin' || auth()->id() == $userId || auth()->id() == $user->company) return true;
        return false;
    }
}
