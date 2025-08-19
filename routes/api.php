<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Mail API Routes - Protected by API Token Authentication
Route::middleware(['api.token.auth'])->group(function () {
    Route::post('/send-email', [MailController::class, 'sendEmail'])->name('api.send-email');

    // Route pour obtenir les informations de l'utilisateur authentifié
    Route::get('/user-info', function (Request $request) {
        $user = $request->user();
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mail_config' => [
                    'mailer' => $user->mail_mailer,
                    'host' => $user->mail_host,
                    'port' => $user->mail_port,
                    'from_address' => $user->mail_from_address,
                    'from_name' => $user->mail_from_name,
                ]
            ]
        ]);
    });
});
