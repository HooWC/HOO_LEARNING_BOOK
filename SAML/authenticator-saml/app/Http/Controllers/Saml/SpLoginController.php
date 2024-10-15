<?php

namespace App\Http\Controllers\Saml;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use SimpleXMLElement;
use Illuminate\Support\Facades\Session;

class SpLoginController extends Controller
{
    public function loginIDP(Request $request)
    {
        $samlResponse = $request->input('SAMLResponse');
        $metaData = $request->input('Metadata');

        $client = new Client();
        $response = $client->request('GET', $metaData);
        $metadataXml = $response->getBody()->getContents();
        $xml = new SimpleXMLElement($metadataXml);
        $xml->registerXPathNamespace('md', 'urn:oasis:names:tc:SAML:2.0:metadata');
        $xml->registerXPathNamespace('ds', 'http://www.w3.org/2000/09/xmldsig#');
        $x509Certificates = [];
        foreach ($xml->xpath('//ds:X509Certificate') as $certificate) {
            $x509Certificates[] = (string)$certificate;
        }
        $binaryCertificate = base64_decode($x509Certificates[0]);
        $publicKey = "-----BEGIN CERTIFICATE-----\n" . chunk_split(base64_encode($binaryCertificate), 64, "\n") . "-----END CERTIFICATE-----\n";

        $privateKey = file_get_contents(storage_path('samlidp/key.pem'));
        openssl_sign($samlResponse, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $signatureBase64 = base64_encode($signature);

        //使用公钥验证签名
        $isSignatureValid = openssl_verify($samlResponse, base64_decode($signatureBase64), $publicKey, OPENSSL_ALGO_SHA256);

        if ($isSignatureValid === 1) {
            $xml = new SimpleXMLElement($samlResponse);
            $request->session()->put('samlResponse', $samlResponse);
            $userJson = (string)$xml->Subject->User;
            $userData = json_decode($userJson);
            $user = User::where('email', $userData->email)->first();
            if (!$user) {
                $user = User::create([
                    'email' => $userData->email,
                    'name' => $userData->name,
                    'password' => $userData->password,
                    'created_at' => $userData->created_at,
                    'updated_at' => $userData->updated_at,
                ]);

                Auth::login($user);
                return redirect('/dashboard');
            }

            Auth::login($user);

            if ($user->open_totp) {
                if ($user->verify_code) {
                    return redirect('/dashboard');
                }

                $userPassword = (string)$xml->Password;
                Session::put('userId', $user->id);
                Session::put('userPassword', $userPassword);
                return redirect()->route('totp.view');
            }

            return redirect('/dashboard');
        }

        return redirect(config('services.idp.idp_login'));
    }

    public function logoutIDP(Request $request)
    {
        $backUrl = $request->query('BackUrl');

        $user = Auth::guard('web')->user();

        if ($user) {
            $user->verify_code = false;
            $user->save();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::to($backUrl);
    }
}
