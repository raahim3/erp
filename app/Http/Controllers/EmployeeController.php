<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeeDataTable;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EmployeeDataTable $dataTable)
    {
        return $dataTable->render('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['designations'] = Designation::where('company_id', auth()->user()->company_id)->get();
        $data['departments'] = Department::where('company_id', auth()->user()->company_id)->get();
        $data['roles'] = Role::where('company_id', auth()->user()->company_id)->get();
        return view('employees.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role_id' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'password' => 'required',
            'hired_at' => 'required',
            'shift_start' => 'required',
            'shift_end' => 'required',
            'status' => 'required',
        ]);

        if($request->hasFile('profile'))
        {
            $file = $request->file('profile');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $request->merge(['profile' => $filename]);
        }

        $user = User::create([
            'name' => $request->first_name.' '.$request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'password' => bcrypt($request->password),
            'hired_at' => $request->hired_at,
            'shift_start' => $request->shift_start,
            'shift_end' => $request->shift_end,
            'status' => $request->status,
            'company_id' => auth()->user()->company_id
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
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
        $data['user'] = User::with('role','department','designation','company')->find($id);
        $data['designations'] = Designation::where('company_id', auth()->user()->company_id)->get();
        $data['departments'] = Department::where('company_id', auth()->user()->company_id)->get();
        $data['roles'] = Role::where('company_id', auth()->user()->company_id)->get();
        return view('employees.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role_id' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'hired_at' => 'required',
            'shift_start' => 'required',
            'shift_end' => 'required',
            'status' => 'required',
        ]);
        
        $user = User::find($id)->update([
            'name' => $request->first_name.' '.$request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'hired_at' => $request->hired_at,
            'shift_start' => $request->shift_start,
            'shift_end' => $request->shift_end,
            'status' => $request->status,
        ]);
        

        if($request->hasFile('profile'))
        {
            $file = $request->file('profile');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            
            $user = User::find($id)->update([
                'profile' => $filename,
            ]);
        }
        if($request->password)
        {
            $request->merge(['password' => bcrypt($request->password)]);
            $user = User::find($id)->update([
                'password' => $request->password,
            ]);
        }
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

}
