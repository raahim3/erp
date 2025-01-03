<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeeLeavesDataTable;
use App\DataTables\LeaveRequestDataTable;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeaveRequestDataTable $dataTable)
    {
        if(!auth()->user()->hasPermission('leave_read'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        $leave_types = LeaveType::where('status', 1)->get();
        $employees = User::where(['status' => 1 , 'company_id' => auth()->user()->company_id ])->get();
        return $dataTable->render('leave_requests.index', compact('leave_types', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!auth()->user()->hasPermission('leave_create'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $existing_leave = LeaveRequest::where('user_id', $request->employee ?? auth()->user()->id)
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                  ->orWhere(function ($query) use ($request) {
                      $query->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                  });
        })
        ->exists();

    if ($existing_leave) {
        return redirect()->back()->with('error', 'A leave request already exists for the selected date range.');
    }
        $request->validate([
            'leave_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ]);

        $leave_request = new LeaveRequest();
        $leave_request->user_id = $request->employee ?? auth()->user()->id;
        $leave_request->leave_type_id = $request->leave_type;
        $leave_request->start_date = $request->start_date;
        $leave_request->end_date = $request->end_date;
        $leave_request->reason = $request->reason;
        $leave_request->save();

        if($request->employee)
        {
            return redirect()->route('leave_requests.index')->with('success', 'Leave request created successfully.');
        }
        else{
            return redirect()->back()->with('success', 'Leave request created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!auth()->user()->hasPermission('leave_edit'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $request->validate([
            'leave_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ]);

        $leave_request = LeaveRequest::find($id);
        $leave_request->user_id = $request->employee ?? auth()->user()->id;
        $leave_request->leave_type_id = $request->leave_type;
        $leave_request->start_date = $request->start_date;
        $leave_request->end_date = $request->end_date;
        $leave_request->reason = $request->reason;
        $leave_request->update();

        return redirect()->route('leave_requests.index')->with('success', 'Leave request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!auth()->user()->hasPermission('leave_delete'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $leave_request = LeaveRequest::find($id);
        $leave_request->delete();

        return redirect()->route('leave_requests.index')->with('success', 'Leave request deleted successfully.');
    }

    public function change_status($id , $status)
    {
        $leave_request = LeaveRequest::find($id);
        $leave_request->status = $status;
        $leave_request->update();
        if($status == 2)
        {
            $message = "Leave request rejected successfully.";
        }
        else
        {
            $message = "Leave request approved successfully.";
        }
        return redirect()->route('leave_requests.index')->with('success', $message);
    }

    public function employee_leaves(Request $request , $employee_id , EmployeeLeavesDataTable $dataTable)
    {
        if(!auth()->user()->hasPermission('own_leaves'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        try {
            $id = Crypt::decrypt($employee_id);
        } catch (\Throwable $th) {
            return abort(404);
        }
        $leave_types = LeaveType::where('status', 1)->get();
        return $dataTable->with(['employee_id' => $id])->render('leave_requests.employee_leave', compact('id','leave_types'));
    }
}
