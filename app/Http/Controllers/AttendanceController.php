<?php

namespace App\Http\Controllers;

use App\DataTables\AttendanceDataTable;
use App\DataTables\EmployeeAttendanceDataTable;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
        if(!$attendance)
        {
            return response()->json(['error' => 'You did not punch in today']);
        }
        if($request->status == 1){
            if($attendance->punch_in){
                return response()->json(['error' => 'You did punch in already']);
            }
            $attendance->punch_in = date('H:i');
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
            $attendance->punch_out = date('H:i');
            
            $punchIn = Carbon::createFromFormat('H:i', $attendance->punch_in);
            $punchOut = Carbon::createFromFormat('H:i', $attendance->punch_out);
            $attendance->production_time = $punchOut->diff($punchIn)->format('%H:%I');
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
    public function update(Request $request)
    {
        $attendance = Attendance::find($request->id);
        $attendance->status = $request->status;
        $attendance->punch_in_behavior = $request->behavior;
        $attendance->punch_in = $request->punch_in;
        $attendance->punch_out = $request->punch_out;
        if($attendance->punch_in && $attendance->punch_out)
        {
            // dd($attendance);
            $punchIn = Carbon::createFromFormat('H:i', $attendance->punch_in);
            $punchOut = Carbon::createFromFormat('H:i', $attendance->punch_out);
            $attendance->production_time = $punchOut->diff($punchIn)->format('%H:%I');
        }
        $attendance->update();
        if($request->is_edit == 1)
        {
            return redirect()->back()->with('success', 'Attendance Updated Successfully');
        }else{

            return redirect()->route('attendance.index')->with('success', 'Attendance Updated Successfully');
        }
    }

    public function employee_attendance(EmployeeAttendanceDataTable $dataTable , $employee_id)
    {
        $id = Crypt::decrypt($employee_id);
        return $dataTable->with(['employee_id' => $id])->render('attendance.employee_attendance');
    }
}
