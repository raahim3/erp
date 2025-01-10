<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
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

        $loan = new Loan();
        $loan->title = $request->title;
        $loan->type = $request->type;
        $loan->amount = $request->amount;
        $loan->user_id = $request->user_id;
        $loan->salary_id = $request->salary_id;
        $loan->company_id = auth()->user()->company_id;
        $loan->save();

        return redirect()->back()->with('success', 'Loan added successfully.');
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

        $loan = Loan::find($id);
        $loan->title = $request->title;
        $loan->type = $request->type;
        $loan->amount = $request->amount;
        $loan->update();

        return redirect()->back()->with('success', 'Loan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loan = Loan::find($id);
        $loan->delete();
        return redirect()->back()->with('success', 'Loan deleted successfully.');
    }
}
