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
        return $dataTable->render('designations.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('designations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $designation = Designation::find($id);
        return view('designations.edit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
        $designation = Designation::with('users')->find($id);
        if(count($designation->users) > 0) {
            return redirect()->route('designations.index')->with('error', 'Designation cannot be deleted because it has users');
        }
        $designation->delete();
        return redirect()->route('designations.index')->with('success', 'Designation Deleted successfully');
    }
}
