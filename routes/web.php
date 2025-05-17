<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\LanguageController;
use App\Http\Controllers\Dashboard\NoteController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\RepresentativeController;
use App\Http\Controllers\Dashboard\SampleController;
use App\Http\Controllers\Dashboard\TicketController;
use App\Http\Controllers\Dashboard\TicketReplyController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\VisitController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;

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

Broadcast::routes(['middleware' => ['web', 'auth:sanctum']]);


Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth',)->group(function () {
    Route::get('swap', [LanguageController::class, 'swap'])->name('swap');
    Route::post('logout',[AuthController::class, 'destroy'])->name('logout');

    Route::middleware('role:superadmin|admin|supervisor')->group(function () {

        Route::get('/', function () {return view('dashboard');})->name('dashboard');

        Route::get('visits', [VisitController::class, 'index'])->name('visits.index');
        Route::get('visits/create', [VisitController::class, 'create'])->name('visits.create');
        Route::post('visits/store', [VisitController::class, 'store'])->name('visits.store');
        Route::get('visits/{visit}', [VisitController::class, 'show'])->name('visits.show');
        Route::put('visits/{visit}/status', [VisitController::class, 'updateStatus'])->name('visits.updateStatus');


        Route::post('visits/{visit}/notes', [NoteController::class, 'store'])->name('visits.notes.store');

        Route::get('representatives/{representative}/visits', [VisitController::class, 'byRepresentative'])->name('representatives.visits');

        Route::get('samples/by-doctor/{doctor}', [SampleController::class, 'getByDoctor'])->name('samples.byDoctor');




        Route::get('representatives', [RepresentativeController::class, 'index'])->name('representatives.index');
        Route::get('representatives/{id}', [RepresentativeController::class, 'show'])->name('representatives.show');
        Route::get('representatives/{representative}/today-visits', [RepresentativeController::class, 'todayVisits'])->name('representatives.today-visits');
        Route::get('representatives/{representative}/stats-json', [RepresentativeController::class, 'statistics'])->name('representatives.statistics');


        Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::put('tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
        Route::get('tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');

        Route::post('tickets/{ticket}/replies', [TicketReplyController::class, 'store'])->name('tickets.replies.store');

        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    });

        Route::get('user', [UserController::class, 'create'])->name('user.create')->middleware('can:view_add_user');
        Route::post('user', [UserController::class, 'store'])->name('user.store')->middleware('can:create_user');



});
