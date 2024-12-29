<?php

namespace App\Http\Controllers;

use App\DataTables\LeaveTypeDataTable;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeaveTypeDataTable $dataTable)
    {
        return $dataTable->render('leave_types.index');
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
        if(!auth()->user()->hasPermission('leave_type_create'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }

        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);

        $leave_type = new LeaveType();
        $leave_type->title = $request->title;
        $leave_type->status = $request->status;
        $leave_type->save();

        return redirect()->route('leave_types.index')->with('success', 'Leave Type created successfully.');
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
        if(!auth()->user()->hasPermission('leave_type_edit'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }

        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);

        $leave_type = LeaveType::find($id);
        $leave_type->title = $request->title;
        $leave_type->status = $request->status;
        $leave_type->update();

        return redirect()->route('leave_types.index')->with('success', 'Leave Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!auth()->user()->hasPermission('leave_type_delete'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $leave_type = LeaveType::find($id);
        $leave_type->delete();

        return redirect()->route('leave_types.index')->with('success', 'Leave Type deleted successfully.');
    }
}
