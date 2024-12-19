<?php

namespace App\Http\Controllers;

use App\DataTables\AttendanceDataTable;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(AttendanceDataTable $dataTable)
    {
        $employees = User::where(['status' => 1 , 'company_id' => auth()->user()->company_id])->get();
        return $dataTable->render('attendance.index', compact('employees'));
    }

    public function createAttendance()
    {
        $all_users = User::where('status', 1)->get();
        foreach($all_users as $user){
            $attendance = new Attendance();
            $attendance->user_id = $user->id;
            $attendance->company_id = $user->company_id;
            $attendance->date = date('Y-m-d');
            $attendance->save();
        }
        return true;
    }
}
