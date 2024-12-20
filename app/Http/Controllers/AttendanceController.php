<?php

namespace App\Http\Controllers;

use App\DataTables\AttendanceDataTable;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(AttendanceDataTable $dataTable)
    {
        $employees = User::where(['status' => 1 , 'company_id' => auth()->user()->company_id ])->get();
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

    public function punch_in(Request $request)
    {
        $attendance = Attendance::where(['user_id' => auth()->user()->id , 'date' => date('Y-m-d')])->first();
        if($request->status == 1){
            $attendance->punch_in = date('H:i:s');
            $attendance->status = '1';
        }else{
            $attendance->punch_out = date('H:i:s');
            
            $punchIn = Carbon::createFromFormat('H:i:s', $attendance->punch_in);
            $punchOut = Carbon::createFromFormat('H:i:s', $attendance->punch_out);
            $attendance->production_time = $punchOut->diff($punchIn)->format('%H:%I:%S');
        }
        $attendance->update();
        // dd($attendance->punch_in , $attendance->punch_out);
        return response()->json(['status' => 200 , 'message' => 'Punch In Time Added Successfully']);
    }
}
