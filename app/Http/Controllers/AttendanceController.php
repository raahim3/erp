<?php

namespace App\Http\Controllers;

use App\DataTables\AttendanceDataTable;
use App\DataTables\EmployeeAttendanceDataTable;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AttendanceController extends Controller
{

    public function index(AttendanceDataTable $dataTable , Request $request)
    {
        if(!auth()->user()->hasPermission('employees_attendance'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
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
        $currentDate = date('Y-m-d');
        $all_users = User::where('status', 1)->get();
        foreach($all_users as $user){
            $leave_request = LeaveRequest::where('user_id', $user->id)
                ->where('status', 1)
                ->whereDate('start_date', '<=', $currentDate)
                ->whereDate('end_date', '>=', $currentDate) 
                ->exists();
            $attendance = new Attendance();
            $attendance->user_id = $user->id;
            $attendance->company_id = $user->company_id;
            $attendance->date = date('Y-m-d');
            $attendance->status = $leave_request ? '2' : '0';
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
            
            $punchIn = Carbon::createFromFormat('H:i:s', $attendance->punch_in);
            $punchOut = Carbon::createFromFormat('H:i', $attendance->punch_out);
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
        $adbsent_count = $all_attendance->where('status', 0)->where('date', date('Y-m-d'))->count(); 
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
            $punchIn = Carbon::createFromFormat('H:i:s', $attendance->punch_in);
            $punchOut = Carbon::createFromFormat('H:i', $attendance->punch_out);
            $attendance->production_time = $punchOut->diff($punchIn)->format('%H:%I:%S');
        }
        $attendance->update();
        if($request->is_edit == 1)
        {
            return redirect()->back()->with('success', 'Attendance Updated Successfully');
        }else{

            return redirect()->route('attendance.index')->with('success', 'Attendance Updated Successfully');
        }
    }

    public function employee_attendance(EmployeeAttendanceDataTable $dataTable , $employee_id, Request $request)
    {
        
        if(!auth()->user()->hasPermission('own_attendance'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        try {
            $id = Crypt::decrypt($employee_id);
        } catch (\Throwable $th) {
            return abort(404);
        }
        $user = User::find($id);
        $search_start_date = $request->start_date ?? null;
        $search_end_date = $request->end_date ?? null;
        $search_status = $request->status ? ($request->status == 'all' ? null : $request->status) : null;
        $search_behavior = $request->behavior ? ($request->behavior == 'all' ? null : $request->behavior)    : null;
        $production_time = 'N/A';
        $punch_in_time = 'N/A';
        $is_punch_in = Attendance::where(['user_id' => $user->id , 'date' => date('Y-m-d')])->whereNotNull('punch_in')->whereNull('punch_out')->exists();
        $today_working_hours = 0;
        $week_working_hours = 0;
        $month_working_hours = 0;

        // Today's Attendance
        $today = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();

        if ($attendance) {
            if ($attendance->punch_in) {
                $punchIn = Carbon::createFromFormat('H:i:s', $attendance->punch_in);
                $punch_in_time = Carbon::createFromFormat('H:i:s', $attendance->punch_in)->format('g:i A');
                $punchOut = $attendance->punch_out
                    ? Carbon::createFromFormat('H:i:s', $attendance->punch_out)
                    : Carbon::now();

                $today_working_hours = $punchIn->diffInHours($punchOut);
                $production_time = $punchIn->diff($punchOut)->format('%H:%I:%S');
            }
        }

        // Calculate Weekly Working Hours
        $week_start = Carbon::now()->startOfWeek()->format('Y-m-d');
        $week_end = Carbon::now()->endOfWeek()->format('Y-m-d');
        $week_attendances = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$week_start, $week_end])
            ->get();

        foreach ($week_attendances as $attendance) {
            if ($attendance->punch_in && $attendance->punch_out) {
                $punchIn = Carbon::createFromFormat('H:i:s', $attendance->punch_in);
                $punchOut = Carbon::createFromFormat('H:i:s', $attendance->punch_out);
                $week_working_hours += $punchIn->diffInHours($punchOut);
            }
        }

        // Calculate Monthly Working Hours
        $month_start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $month_end = Carbon::now()->endOfMonth()->format('Y-m-d');
        $month_attendances = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$month_start, $month_end])
            ->get();

        foreach ($month_attendances as $attendance) {
            if ($attendance->punch_in && $attendance->punch_out) {
                $punchIn = Carbon::createFromFormat('H:i:s', $attendance->punch_in);
                $punchOut = Carbon::createFromFormat('H:i:s', $attendance->punch_out);
                $month_working_hours += $punchIn->diffInHours($punchOut);
            }
        }

        $currentHour = Carbon::now()->format('H');

        if ($currentHour >= 5 && $currentHour < 12) {
            $greeting = "Good Morning";
        } elseif ($currentHour >= 12 && $currentHour < 17) {
            $greeting = "Good Afternoon";
        } elseif ($currentHour >= 17 && $currentHour < 21) {
            $greeting = "Good Evening";
        } else {
            $greeting = "Good Night";
        }
        $shift_start = $user->shift_start;
        $shift_end = $user->shift_end;
        $start_time = Carbon::createFromFormat('H:i:s', $shift_start);
        if ($shift_end < $shift_start) {
            $end_time = Carbon::createFromFormat('H:i:s', $shift_end)->addDay();
        } else {
            $end_time = Carbon::createFromFormat('H:i:s', $shift_end);
        }
        $total_shift_hour = $start_time->diffInHours($end_time);
        $total_shift_week_hour = $start_time->diffInHours($end_time) * 7;
        $total_this_monyh_days = Carbon::now()->daysInMonth;
        $total_shift_month_hour = $start_time->diffInHours($end_time) * $total_this_monyh_days;

        return $dataTable->with(['employee_id' => $id , 'search_start_date' => $search_start_date , 'search_end_date' => $search_end_date , 'search_status' => $search_status , 'search_behavior' => $search_behavior])->render('attendance.employee_attendance', compact('production_time','punch_in_time','is_punch_in','greeting','total_shift_hour','total_shift_week_hour','total_shift_month_hour','user','month_working_hours','week_working_hours','today_working_hours'));
    }
}
