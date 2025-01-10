<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'amount' => 'required',
        ]);

        $allowance = new Allowance();
        $allowance->title = $request->title;
        $allowance->type = $request->type;
        $allowance->amount = $request->amount;
        $allowance->user_id = $request->user_id;
        $allowance->salary_id = $request->salary_id;
        $allowance->company_id = auth()->user()->company_id;
        $allowance->save();

        return redirect()->back()->with('success', 'Allowance added successfully.');
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
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'amount' => 'required',
        ]);

        $allowance = Allowance::find($id);
        $allowance->title = $request->title;
        $allowance->type = $request->type;
        $allowance->amount = $request->amount;
        $allowance->update();

        return redirect()->back()->with('success', 'Allowance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $allowance = Allowance::find($id);
        $allowance->delete();
        return redirect()->back()->with('success', 'Allowance deleted successfully.');
    }
}
