<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\LanguageController;
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

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth',)->group(function () {
    Route::get('swap', [LanguageController::class, 'swap'])->name('swap');
    Route::post('logout',[AuthController::class, 'destroy'])->name('logout');

    Route::middleware('role:superadmin|admin|supervisor')->group(function () {
        Route::get('/', function () {return view('dashboard');})->name('dashboard');
    });

        Route::get('user', [UserController::class, 'create'])->name('user.create')->middleware('can:view_add_user');
        Route::post('user', [UserController::class, 'store'])->name('user.store')->middleware('can:create_user');

        Route::get('visits', [VisitController::class, 'index'])->name('visits.index');
        Route::get('visits/{id}', [VisitController::class, 'show'])->name('visits.show');


});
