<?php

namespace App\Http\Controllers;

use App\DataTables\PayslipDataTable;
use App\Models\payslip;
use App\Models\User;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PayslipDataTable $dataTable)
    {
        return $dataTable->render('payroll.payslip');
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
            'month_year' => 'required',
        ]);
        $month = date('F', strtotime($request->month_year));
        $year = date('Y', strtotime($request->month_year));

        $employees = User::with('salary')->where(['status' => 1 , 'company_id' => auth()->user()->company_id ])->get();
        foreach ($employees as $employee) {
            $check = payslip::where(['user_id' => $employee->id , 'payslip_month' => $month , 'payslip_year' => $year])->first();
            if (!$check) {
                $payslip = new payslip();
                $payslip->user_id = $employee->id;
                $payslip->company_id = $employee->company_id;
                $payslip->salary_id = $employee->salary[0]->id;
                $payslip->net_salary = $employee->salary[0]->salary;
                $payslip->payslip_month = $month;
                $payslip->payslip_year = $year;
                $payslip->save();    
            }
        }

        return redirect()->route('payslips.index')->with('success', 'Payslip Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payslip = payslip::with('user','salary')->find($id);
        return view('payroll.slip' , compact('payslip'));
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
        $payslip = payslip::find($id);
        $payslip->delete();
        return redirect()->back()->with('success', 'Payslip deleted successfully.');
    }

    public function change_status($id, $status)
    {
        $payslip = payslip::find($id);
        $payslip->status = $status;
        $payslip->update();
        if ($status == 'unpaid') {
            $message = "Payslip Unpaid successfully.";
        } else {
            $message = "Payslip Paid successfully.";
        }
        return redirect()->route('payslips.index')->with('success', $message);
    }
}
