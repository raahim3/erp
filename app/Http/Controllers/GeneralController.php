<?php

namespace App\Http\Controllers;

use App\Models\General;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!auth()->user()->hasPermission('general_setting'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        $settings = General::where('company_id', auth()->user()->company_id)->first();
        return view('settings.general', compact('settings'));
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
        //
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
        if(!auth()->user()->hasPermission('general_setting'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $request->validate([
            'title' => 'required',
        ]);

        $general = General::where('company_id', auth()->user()->company_id)->first();
        $general->title = $request->title;
        $general->description = $request->description;
        $general->email = $request->email;
        $general->phone = $request->phone;
        $general->address = $request->address;
        $general->primary_color = $request->primary_color;
        if($request->hasFile('light_logo'))
        {
            $light_logo_file = $request->file('light_logo');
            $light_logo_filename = time().'_'.$light_logo_file->getClientOriginalName();
            $light_logo_file->move(public_path('uploads/logos'), $light_logo_filename);
            $general->light_logo = $light_logo_filename;
        }
        if($request->hasFile('dark_logo'))
        {
            $dark_logo_file = $request->file('dark_logo');
            $dark_logo_filename = time().'_'.$dark_logo_file->getClientOriginalName();
            $dark_logo_file->move(public_path('uploads/logos'), $dark_logo_filename);
            $general->dark_logo = $dark_logo_filename;
        }
        if($request->hasFile('favicon'))
        {
            $favicon_file = $request->file('favicon');
            $favicon_filename = time().'_'.$favicon_file->getClientOriginalName();
            $favicon_file->move(public_path('uploads/logos'), $favicon_filename);
            $general->favicon = $favicon_filename;
        }
        $general->save();
        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
