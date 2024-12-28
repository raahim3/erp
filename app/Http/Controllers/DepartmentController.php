<?php

namespace App\Http\Controllers;

use App\DataTables\DepartmentDataTable;
use App\Models\Department;
use Illuminate\Http\Request;

use function Termwind\render;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DepartmentDataTable $dataTable)
    {
        if(!auth()->user()->hasPermission('department_read'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        return $dataTable->render('departments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!auth()->user()->hasPermission('department_create'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!auth()->user()->hasPermission('department_create'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $request->validate([
            'name' => 'required'
        ]);

        Department::create([
            'name' => $request->name,
            'description' => $request->description,
            'company_id' => auth()->user()->company_id
        ]);

        return redirect()->route('departments.index')->with('success', 'Department created successfully');
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
        if(!auth()->user()->hasPermission('department_edit'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        $department = Department::find($id);
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!auth()->user()->hasPermission('department_edit'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $request->validate([
            'name' => 'required'
        ]);

        Department::find($id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!auth()->user()->hasPermission('department_delete'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $department = Department::with('users')->find($id);
        if(count($department->users) > 0) {
            return redirect()->route('departments.index')->with('error', 'Department cannot be deleted because it has users');
        }
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department Deleted successfully');
    }
}
