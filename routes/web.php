<?php

use App\Http\Controllers\{AttendanceController, DepartmentController, DesignationController, EmployeeController, GeneralController, HomeController, LeaveRequestController, LeaveTypeController, RoleController, SmtpController};
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
    Route::any('roles/permissions/{id}',[RoleController::class,'permissions'])->name('roles.permissions');
    Route::resource('departments', DepartmentController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('employees', EmployeeController::class);
    Route::get('attendance',[AttendanceController::class,'index'])->name('attendance.index');
    Route::get('attendance/{employee_id}',[AttendanceController::class,'employee_attendance'])->name('attendance.employee');
    Route::get('create/attendance',[AttendanceController::class,'createAttendance'])->name('attendance.create');
    Route::post('punch_in',[AttendanceController::class,'punch_in'])->name('punch.in');
    Route::post('get/attendance/data', [AttendanceController::class, 'getAttendanceData'])->name('get.attendance.data');
    Route::post('attendance/update',[AttendanceController::class,'update'])->name('attendances.update');

    Route::resource('leave_types', LeaveTypeController::class);
    Route::resource('leave_requests', LeaveRequestController::class);
    Route::get('leave_requests/{id}/{status}', [LeaveRequestController::class, 'change_status'])->name('leave_requests.change_status');

    Route::resource('settings/general', GeneralController::class);
    Route::resource('settings/smtp', SmtpController::class);
    Route::post('settings/smtp/test', [SmtpController::class, 'test'])->name('smtp.test');
});
