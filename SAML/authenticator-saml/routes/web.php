<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Saml\SpLoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use \App\Http\Controllers\Totp\VerifyTotpController;
use \App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    $samlResponse = $request->input('SAMLResponse');
    if ($samlResponse) {
        $SpLoginController = new SpLoginController();
        return $SpLoginController->loginIDP($request);
    }

    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class,'checkingVerify'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('verify', [VerifyTotpController::class, 'index'])->name('totp.view');
    Route::post('verify', [VerifyTotpController::class, 'verifyTotp'])->name('totp.verify');
});

require __DIR__.'/auth.php';
