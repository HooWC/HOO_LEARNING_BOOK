<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TotpController extends Controller
{
    public function updateOpenTotp(Request $request)
    {
        $userId = $request->input('userId');

        $user = User::find($userId);
        $user->open_totp = !$user->open_totp;
        $user->verify_code = false;
        $user->save();

        return response()->json([
            'message' => "User open totp is update success!"
        ]);
    }
}
