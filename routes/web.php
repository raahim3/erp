<?php

use App\Http\Controllers\{AttendanceController, DepartmentController, DesignationController, EmployeeController, GeneralController, HomeController, RoleController, SmtpController};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('employees', EmployeeController::class);
    Route::get('attendance',[AttendanceController::class,'index'])->name('attendance.index');
    Route::get('attendance/create',[AttendanceController::class,'createAttendance'])->name('attendance.create');
    Route::post('punch_in',[AttendanceController::class,'punch_in'])->name('punch.in');
    Route::resource('settings/general', GeneralController::class);
    Route::resource('settings/smtp', SmtpController::class);
    Route::post('settings/smtp/test', [SmtpController::class, 'test'])->name('smtp.test');
});
