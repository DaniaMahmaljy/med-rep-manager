<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\LanguageController;
use App\Http\Controllers\Dashboard\RepresentativeController;
use App\Http\Controllers\Dashboard\SampleController;
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

        Route::get('visits', [VisitController::class, 'index'])->name('visits.index');
        Route::get('visits/create', [VisitController::class, 'create'])->name('visits.create');
        Route::post('visits/store', [VisitController::class, 'store'])->name('visits.store');
        Route::get('visits/{id}', [VisitController::class, 'show'])->name('visits.show');

        Route::get('representatives/{representative}/visits', [VisitController::class, 'byRepresentative'])->name('representatives.visits');

        Route::get('samples/by-doctor/{doctor}', [SampleController::class, 'getByDoctor'])->name('samples.byDoctor');


        Route::get('representatives', [RepresentativeController::class, 'index'])->name('representatives.index');
        Route::get('representatives/{id}', [RepresentativeController::class, 'show'])->name('representatives.show');
        Route::get('representatives/{representative}/today-visits', [RepresentativeController::class, 'todayVisits'])->name('representatives.today-visits');
        Route::get('representatives/{representative}/stats-json', [RepresentativeController::class, 'statistics'])->name('representatives.statistics');


    });

        Route::get('user', [UserController::class, 'create'])->name('user.create')->middleware('can:view_add_user');
        Route::post('user', [UserController::class, 'store'])->name('user.store')->middleware('can:create_user');



});
