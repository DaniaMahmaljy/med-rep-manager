<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\LanguageController;
use App\Http\Controllers\Dashboard\NoteController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\PasswordController;
use App\Http\Controllers\Dashboard\RepresentativeController;
use App\Http\Controllers\Dashboard\SampleController;
use App\Http\Controllers\Dashboard\SupervisorController;
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
Route::get('password/forget-password', [PasswordController::class, 'showForgetPasswordForm'])->name('password.forget');
Route::post('password/email', [PasswordController::class, 'sendOTPEmail'])->name('password.email');
Route::get('password/reset-password', [PasswordController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('password/reset-password', [PasswordController::class, 'resetPasswordOTP'])->name('password.reset');


Route::middleware('auth',)->group(function () {
    Route::get('password/change', [PasswordController::class, 'showChangeForm'])->name('password.change.form');
    Route::post('password/change', [PasswordController::class, 'changePassword'])->name('password.change');

    Route::get('swap', [LanguageController::class, 'swap'])->name('swap');
    Route::post('logout',[AuthController::class, 'destroy'])->name('logout');
    Route::get('user', [UserController::class, 'create'])->name('user.create')->middleware('can:view_add_user');
    Route::post('user', [UserController::class, 'store'])->name('user.store')->middleware('can:create_user');
    Route::get('doctors/create', [DoctorController::class, 'create'])->name('doctors.create')->middleware('can:view_add_doctor');
    Route::post('doctors/store', [DoctorController::class, 'store'])->name('doctors.store')->middleware('can:create_doctor');
    Route::get('supervisors', [SupervisorController::class, 'index'])->name('supervisors.index')->middleware('role:superadmin|admin');;
    Route::get('admins', [AdminController::class, 'index'])->name('admins.index')->middleware('role:superadmin|admin');;

    Route::post('/doctors/{doctor}/assign-supervisors', [DoctorController::class, 'assignSupervisors']) ->name('doctors.assignSupervisors');
    Route::post('/representatives/{representative}/update-assignments', [RepresentativeController::class, 'updateAssignments'])->middleware('role:superadmin|admin');


    Route::middleware('role:superadmin|admin|supervisor')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('visits', [VisitController::class, 'index'])->name('visits.index');
        Route::get('visits/create', [VisitController::class, 'create'])->name('visits.create');
        Route::post('visits/store', [VisitController::class, 'store'])->name('visits.store');
        Route::get('visits/{visit}', [VisitController::class, 'show'])->name('visits.show');
        Route::put('visits/{visit}/status', [VisitController::class, 'updateStatus'])->name('visits.updateStatus');


        Route::post('visits/{visit}/notes', [NoteController::class, 'store'])->name('visits.notes.store');

        Route::get('representatives/{representative}/visits', [VisitController::class, 'byRepresentative'])->name('representatives.visits');

        Route::get('samples/by-doctor/{doctor}', [SampleController::class, 'getByDoctor'])->name('samples.byDoctor');


        Route::get('doctors', [DoctorController::class, 'index'])->name('doctors.index');
        Route::get('doctors/{id}', [DoctorController::class, 'show'])->name('doctors.show');
        Route::get('doctors/{doctor}/stats-json', [DoctorController::class, 'statistics'])->name('doctors.statistics');
        Route::get('doctors/{doctor}/visits', [VisitController::class, 'byDoctor'])->name('doctors.visits');









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





});
