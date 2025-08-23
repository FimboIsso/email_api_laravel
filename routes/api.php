<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Api\EmailStatisticsController;

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

// Route Sanctum optionnelle (si vous voulez utiliser Sanctum pour certaines fonctionnalités)
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Mail API Routes - Protected by API Token Authentication
Route::middleware(['api.token.auth'])->group(function () {
    Route::post('/send-email', [MailController::class, 'sendEmail'])->name('api.send-email');

    // Routes pour les statistiques d'emails
    Route::prefix('statistics')->name('api.statistics.')->group(function () {
        // Statistiques utilisateur
        Route::get('/user', [EmailStatisticsController::class, 'userStats'])->name('user');

        // Statistiques par token
        Route::get('/token/{tokenId}', [EmailStatisticsController::class, 'tokenStats'])->name('token');

        // Statistiques par application
        Route::get('/application/{applicationName}', [EmailStatisticsController::class, 'applicationStats'])->name('application');

        // Statistiques globales
        Route::get('/global', [EmailStatisticsController::class, 'globalStats'])->name('global');

        // Historique des emails
        Route::get('/emails', [EmailStatisticsController::class, 'emailHistory'])->name('emails.history');

        // Détails d'un email
        Route::get('/emails/{emailId}', [EmailStatisticsController::class, 'emailDetails'])->name('emails.details');
    });

    // Route pour obtenir les informations de l'utilisateur authentifié
    Route::get('/user', function (Request $request) {
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
