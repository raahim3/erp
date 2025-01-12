<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use Illuminate\Http\Request;

class OvertimeController extends Controller
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
            'days' => 'required',
            'rate' => 'required',
            'hours' => 'required',
        ]);

        $overime = new Overtime();
        $overime->title = $request->title;
        $overime->rate = $request->rate;
        $overime->days = $request->days;
        $overime->hours = $request->hours;
        $overime->user_id = $request->user_id;
        $overime->salary_id = $request->salary_id;
        $overime->company_id = auth()->user()->company_id;
        $overime->save();

        return redirect()->back()->with('success', 'Overtime added successfully.');
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
            'days' => 'required',
            'rate' => 'required',
            'hours' => 'required',
        ]);

        $overime = Overtime::find($id);
        $overime->title = $request->title;
        $overime->rate = $request->rate;
        $overime->days = $request->days;
        $overime->hours = $request->hours;
        $overime->save();

        return redirect()->back()->with('success', 'Overtime updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $overime = Overtime::find($id);
        $overime->delete();
        return redirect()->back()->with('success', 'Overtime deleted successfully.');
    }
}
