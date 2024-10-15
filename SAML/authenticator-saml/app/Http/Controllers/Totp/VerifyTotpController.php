<?php

namespace App\Http\Controllers\Totp;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class VerifyTotpController extends Controller
{
    public function index()
    {
        $userId = Session::get('userId');
        if (!$userId)
            return redirect(config('services.idp.idp_logout'));


        // 在這裏添加 檢查 ？
        // 有沒有登入過 a 項目 ？


        // 如果有登入過的話
//        if(){
//
//        }


//        $userPassword = Session::get('userPassword');
//        $user = User::where('id', $userId)->first();
//
//        // 獲取Token
//        $response = Http::post(config('services.totp.totp_api_login'), [
//            'email' => $user->email,
//            'password' => $userPassword,
//        ]);


        // 這邊檢查 ， 然後如果還沒有登入過TOTP的話，就顯示錯誤信息


//        if ($response['message'] != 'Login successfully') {
//            // 如果 message 不是 Login successfully 的話 ， 代表用戶沒有登入過 a 項目
//            // 1. 返回 a 項目 / 發生a 項目的url 去 idp login view ？
//            // 2. 返回 a 項目 / home page
//            // ？。 要不要發送錯誤信息 ？
//            //
//
//            // 按了驗證按鈕 ？
//            //
//        }




        // 發生一個錯誤的信息 ？
        //return view('components.content.totp', compact('userId'))->with('redirectUrl', 'http://127.0.0.1:8080/');

        //return view('components.content.totp', compact('userId'))->with(['errorMessage' => '发生了一个错误', 'url' => $redirectUrl]);


        return view('components.content.totp', compact('userId'));
    }

    public function verifyTotp(Request $request)
    {
        $userPassword = Session::get('userPassword');
        $userId = $request->input('userId');
        $user = User::where('id', $userId)->first();

        // 獲取Token
        $response = Http::post(config('services.totp.totp_api_login'), [
            'email' => $user->email,
            'password' => $userPassword,
        ]);

        $data = $response->json();
        $otp = '';
        for ($i = 1; $i <= 6; $i++) {
            $inputName = 'num' . $i;
            $otp .= $request->input($inputName, '');
        }

        // 獲取用戶所有的authenticator
        $response = Http::withToken($data['token'])->get(config('services.totp.totp_api_authenticator'));

        $authenticator_id = '';
        foreach ($response->json()['data'] as $item) {
            if ($item['account_name'] === config('services.totp.totp_project_name'))
                $authenticator_id = $item['authenticator_id'];
        }

        if (!$authenticator_id)
            return redirect()->route('totp.view');

        // 驗證 OTP
        $response = Http::withToken($data['token'])->post(config('services.totp.totp_api_verify'), [
            'authenticator_id' => $authenticator_id,
            'code' => $otp,
        ]);

        if ($response->json()['authenticator']) {
            $user->verify_code = true;
            $user->save();
            Auth::login($user);
            return redirect('/dashboard');
        }

        return redirect()->route('totp.view');
    }
}
