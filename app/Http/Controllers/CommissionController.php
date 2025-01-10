<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
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

        $commission = new Commission();
        $commission->title = $request->title;
        $commission->type = $request->type;
        $commission->amount = $request->amount;
        $commission->user_id = $request->user_id;
        $commission->salary_id = $request->salary_id;
        $commission->company_id = auth()->user()->company_id;
        $commission->save();

        return redirect()->back()->with('success', 'Commission added successfully.');
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

        $commission = Commission::find($id);
        $commission->title = $request->title;
        $commission->type = $request->type;
        $commission->amount = $request->amount;
        $commission->update();

        return redirect()->back()->with('success', 'Commission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $commission = Commission::find($id);
        $commission->delete();
        return redirect()->back()->with('success', 'Commission deleted successfully.');
    }
}
