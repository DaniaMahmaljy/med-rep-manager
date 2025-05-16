<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\RepresentativeController;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\TicketReplyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout']) ->middleware('auth:sanctum');

Route::middleware('role:representative', 'auth:sanctum')->group(function () {

    Route::get('visits', [RepresentativeController::class, 'allVisits']);
    Route::get('visits/today', [RepresentativeController::class, 'todayVisits']);

    Route::get('tickets', [TicketController::class, 'index']);
    Route::post('tickets', [TicketController::class, 'store']);
    Route::get('tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');

    Route::post('tickets/{ticket}/replies', [TicketReplyController::class, 'store'])->name('tickets.replies.store');

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');


});
