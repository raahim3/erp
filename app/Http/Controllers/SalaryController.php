<?php

namespace App\Http\Controllers;

use App\DataTables\SalaryDataTable;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SalaryDataTable $dataTable)
    {
        if(!auth()->user()->hasPermission('salary_read'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        return $dataTable->render('payroll.salaries.index');
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
        if(!auth()->user()->hasPermission('give_increment_decrement'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        
        $request->validate([
            'salary' => 'required',
            'effective_date' => 'required|date',
            'user_id' => 'required',
            'change_type' => 'required',
        ]);
        $prev_salary = Salary::where('user_id', $request->user_id)->where('status', 1)->first();
        if($prev_salary)
        {
            if($request->change_type == 'increment')
            {
                if($prev_salary->salary >= $request->salary)
                {
                    return redirect()->back()->with('error', 'Previous salary is greater than or equal to new salary.');
                }
            }
            else if($request->change_type == 'decrement')
            {
                if($prev_salary->salary <= $request->salary)
                {
                    return redirect()->back()->with('error', 'Previous salary is less than or equal to new salary.');
                }
            }
        }
        $prev_salary->status = 0;
        $prev_salary->update();
        
        $salary = new Salary();
        $salary->salary = $request->salary;
        $salary->effective_date = $request->effective_date;
        $salary->user_id = $request->user_id;
        $salary->company_id = auth()->user()->company_id;
        $salary->action_by = auth()->user()->id;
        $salary->type = $request->change_type;
        $salary->status = 1;
        $salary->save();

        return redirect()->route('salaries.index')->with('success', 'New salary added successfully.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function history($id)
    {
        if(!auth()->user()->hasPermission('employees_salary_history'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $id = Crypt::decrypt($id);
        $user = User::with('salaries')->find($id);
        $salaries = $user->salaries()->latest()->get();
        return view('payroll.salaries.history',compact('salaries'));
    }
}
