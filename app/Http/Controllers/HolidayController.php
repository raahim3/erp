<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!auth()->user()->hasPermission('holiday_read'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        $holidays = Holiday::where('company_id', auth()->user()->company_id)->get();
        return view('holidays.index', compact('holidays'));
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
        if(!auth()->user()->hasPermission('holiday_create'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'status' => 'required',
        ]);

        $holiday = new Holiday();
        $holiday->title = $request->title;
        $holiday->date = $request->date;
        $holiday->description = $request->description;
        $holiday->status = $request->status;
        $holiday->company_id = auth()->user()->company_id;
        $holiday->user_id = auth()->user()->id;
        $holiday->save();

        return redirect()->route('holidays.index')->with('success', 'Holiday created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $holiday = Holiday::find($id);
        return response()->json($holiday);
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
        if(!auth()->user()->hasPermission('holiday_edit'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'status' => 'required',
        ]);

        $holiday = Holiday::find($id);
        $holiday->title = $request->title;
        $holiday->date = $request->date;
        $holiday->description = $request->description;
        $holiday->status = $request->status;
        $holiday->update();

        return redirect()->route('holidays.index')->with('success', 'Holiday updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!auth()->user()->hasPermission('holiday_delete'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $holiday = Holiday::find($id);
        $holiday->delete();
        return redirect()->route('holidays.index')->with('success', 'Holiday deleted successfully');
    }
}
