<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use SimpleXMLElement;

class DashboardController extends Controller
{
    public function checkingVerify(Request $request)
    {
        $user = Auth::guard('web')->user();

        if ($user->open_totp) {
            if ($user->verify_code) {
                return view('dashboard');
            }

            $samlResponse = $request->session()->get('samlResponse');
            $xml = new SimpleXMLElement($samlResponse);
            $userPassword = (string)$xml->Password;
            Session::put('userId', $user->id);
            Session::put('userPassword', $userPassword);
            return redirect()->route('totp.view');
        }

        return view('dashboard');
    }
}
