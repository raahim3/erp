<?php

namespace App\Http\Controllers;

use App\DataTables\AttendanceDataTable;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function index(AttendanceDataTable $dataTable , Request $request)
    {
        $employees = User::where(['status' => 1 , 'company_id' => auth()->user()->company_id ])->get();
        $all_attendance = Attendance::with('user')->where('company_id', auth()->user()->company_id)->get();
        $present_count = $all_attendance->where('status', 1)->where('date', date('Y-m-d'))->count(); 
        $absent_count = $all_attendance->where('status', 0)->where('date', date('Y-m-d'))->count(); 
        $leave_count = $all_attendance->where('status', 2)->where('date', date('Y-m-d'))->count();
        $search_emp = $request->employee_id ? ($request->employee_id == 'all' ? null : $request->employee_id) : null;
        $search_date = $request->date ?? null;
        $search_status = $request->status ? ($request->status == 'all' ? null : $request->status) : null;
        $search_behavior = $request->behavior ? ($request->behavior == 'all' ? null : $request->behavior)    : null;
        // dd($search_behavior );
        return $dataTable->with(['search_emp' => $search_emp , 'search_date' => $search_date , 'search_status' => $search_status , 'search_behavior' => $search_behavior])->render('attendance.index', compact('employees', 'present_count', 'absent_count', 'leave_count'));
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

    public function punch_in(Request $request)
    {
        $attendance = Attendance::with('user')->where(['user_id' => auth()->user()->id , 'date' => date('Y-m-d')])->first();
        if($request->status == 1){
            if($attendance->punch_in){
                return response()->json(['error' => 'You did punch in already']);
            }
            $attendance->punch_in = date('H:i:s');
            $attendance->status = '1';
            $shift_start = strtotime($attendance->user->shift_start);
            $punch_in = strtotime($attendance->punch_in);
            $grace_time = 10 * 60;

            if ($punch_in > $shift_start + $grace_time) {
                $attendance->punch_in_behavior = 'late';
            } elseif ($punch_in < $shift_start) {
                $attendance->punch_in_behavior = 'early';
            } else {
                $attendance->punch_in_behavior = 'regular';
            }
            $message = "Punch In Time Added Successfully";

        }else{
            $attendance->punch_out = date('H:i:s');
            
            $punchIn = Carbon::createFromFormat('H:i:s', $attendance->punch_in);
            $punchOut = Carbon::createFromFormat('H:i:s', $attendance->punch_out);
            $attendance->production_time = $punchOut->diff($punchIn)->format('%H:%I:%S');
            $message = "You did punch out successfully";
        }
        $attendance->update();
        return response()->json(['status' => 200 , 'message' => $message]);
    }
    public function getAttendanceData(Request $request)
    {
        $all_attendance = Attendance::with('user')->where('company_id', auth()->user()->company_id)->get();
        $present_count = $all_attendance->where('status', 1)->where('date', date('Y-m-d'))->count(); 
        $absent_count = $all_attendance->where('status', 0)->where('date', date('Y-m-d'))->count(); 
        $leave_count = $all_attendance->where('status', 2)->where('date', date('Y-m-d'))->count();
        return response()->json(['present_count' => $present_count , 'absent_count' => $absent_count , 'leave_count' => $leave_count]); 
    }
    public function edit($id)
    {
        
    }
}
