<?php

namespace App\Http\Controllers;

use App\DataTables\DesignationDataTable;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DesignationDataTable $dataTable)
    {
        if(!auth()->user()->hasPermission('designation_read'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        return $dataTable->render('designations.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!auth()->user()->hasPermission('designation_create'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        return view('designations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!auth()->user()->hasPermission('designation_create'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $request->validate([
            'name' => 'required'
        ]);

        Designation::create([
            'name' => $request->name,
            'description' => $request->description,
            'company_id' => auth()->user()->company_id
        ]);

        return redirect()->route('designations.index')->with('success', 'Designation created successfully');
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
        if(!auth()->user()->hasPermission('designation_edit'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        $designation = Designation::find($id);
        return view('designations.edit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!auth()->user()->hasPermission('designation_edit'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $request->validate([
            'name' => 'required'
        ]);

        Designation::find($id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('designations.index')->with('success', 'Designation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!auth()->user()->hasPermission('designation_delete'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $designation = Designation::with('users')->find($id);
        if(count($designation->users) > 0) {
            return redirect()->route('designations.index')->with('error', 'Designation cannot be deleted because it has users');
        }
        $designation->delete();
        return redirect()->route('designations.index')->with('success', 'Designation Deleted successfully');
    }
}
