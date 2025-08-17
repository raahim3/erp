@extends('layouts.app')
@section('title',$payslip->user->name . ' Payslip')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>Payslips</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Payroll</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Payslips</a></li>
                    <li class="breadcrumb-item active">{{ $payslip->user->name }}</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
       
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table style="width: 100%; font-family: Arial, sans-serif; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 20px;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 50%;">
                                            <img src="{{ asset('uploads/logos').'/'.$setting->dark_logo }}" alt="{{ $setting->title }}" style="width: 120px;">
                                            <div style="color: #666; font-size: 14px;">{{ $setting->address }}</div>
                                        </td>
                                        <td style="text-align: right;">
                                            <div style="margin-bottom: 7px;">Payslip No <span style="color: #FF5722;">#PS{{ $payslip->id }}</span></div>
                                            <div>Salary Month : {{ $payslip->payslip_month.' '.$payslip->payslip_year }}</div>
                                        </td>
                                    </tr>
                                </table>
                    
                                <table style="width: 100%; margin-top: 30px;">
                                    <tr>
                                        <td style="width: 50%;">
                                            <div style="font-weight: bold;margin-bottom: 7px;">From</div>
                                            <div style="font-weight: bold; font-size: 18px;margin-bottom: 7px;">{{ $setting->title }}</div>
                                            <div style="color: #666;margin-bottom: 7px;">{{ $setting->address }}</div>
                                            <div style="color: #666;margin-bottom: 7px;">Email : {{ $setting->email }}</div>
                                            <div style="color: #666;margin-bottom: 7px;">Phone : {{ $setting->phone }}</div>
                                        </td>
                                        <td>
                                            <div style="font-weight: bold;margin-bottom: 7px;">To</div>
                                            <div style="font-weight: bold; font-size: 18px;margin-bottom: 7px;">{{ $payslip->user->name }}</div>
                                            <div style="color: #666;margin-bottom: 7px;">{{ $payslip->user->designation->name }}</div>
                                            <div style="color: #666;margin-bottom: 7px;">Email : {{ $payslip->user->email }}</div>
                                            <div style="color: #666;margin-bottom: 7px;">Phone : {{ $payslip->user->phone }}</div>
                                        </td>
                                    </tr>
                                </table>
                    
                                <table style="width: 100%; margin-top: 30px;">
                                    <tr>
                                        <td style="text-align: center; padding: 10px; background-color: #f5f5f5; font-weight: bold;">
                                            Payslip for the month of {{ $payslip->payslip_month.' '.$payslip->payslip_year }}
                                        </td>
                                    </tr>
                                </table>
                                @php( $earning_subtotal = 0  )
                                <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 50%; padding: 10px; background-color: #f9f9f9;vertical-align: baseline;">
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td colspan="2" style="font-weight: bold; padding: 10px; background-color: #dbdbdb;">Earnings</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 10px;">Basic Salary</td>
                                                    <td style="text-align: right;padding: 10px;">${{ $payslip->salary->salary }}</td>
                                                </tr>

                                                @foreach($payslip->salary->allowances as $allowance)
                                                    <?php
                                                        if($allowance->type == 'fixed'){
                                                            $amount = $allowance->amount; 
                                                        }else{
                                                            $amount = $allowance->amount * $payslip->salary->salary / 100;
                                                        }
                                                        $earning_subtotal += $amount;
                                                    ?>
                                                    <tr>
                                                        <td style="padding: 10px;">{{ $allowance->title }}</td>
                                                        <td style="text-align: right;padding: 10px;">${{ $amount }}</td>
                                                    </tr>    
                                                @endforeach

                                                @foreach($payslip->salary->commissions as $commission)
                                                    <?php
                                                        if($commission->type == 'fixed'){
                                                            $amount = $commission->amount; 
                                                        }else{
                                                            $amount = $commission->amount * $payslip->salary->salary / 100;
                                                        }
                                                        $earning_subtotal += $amount;
                                                    ?>
                                                    <tr>
                                                        <td style="padding: 10px;">{{ $commission->title }}</td>
                                                        <td style="text-align: right;padding: 10px;">${{ $amount }}</td>
                                                    </tr>    
                                                @endforeach


                                                @foreach($payslip->salary->commissions as $commission)
                                                    <?php
                                                        if($commission->type == 'fixed'){
                                                            $amount = $commission->amount; 
                                                        }else{
                                                            $amount = $commission->amount * $payslip->salary->salary / 100;
                                                        }
                                                        $earning_subtotal += $amount;
                                                    ?>
                                                    <tr>
                                                        <td style="padding: 10px;">{{ $commission->title }}</td>
                                                        <td style="text-align: right;padding: 10px;">${{ $amount }}</td>
                                                    </tr>    
                                                @endforeach
                                                
                                                @foreach($payslip->salary->overtimes as $overtime)
                                                    <?php
                                                        if($overtime->type == 'fixed'){
                                                            $amount = $overtime->amount; 
                                                        }else{
                                                            $amount = $overtime->amount * $payslip->salary->salary / 100;
                                                        }
                                                        $earning_subtotal += $amount;
                                                    ?>
                                                    <tr>
                                                        <td style="padding: 10px;">{{ $overtime->title }}</td>
                                                        <td style="text-align: right;padding: 10px;">${{ $amount }}</td>
                                                    </tr>    
                                                @endforeach 
                                                <tr>
                                                    <td style="font-weight: bold;padding: 10px;">Total Earnings</td>
                                                    <td style="text-align: right;padding: 10px; font-weight: bold;">${{$earning_subtotal}}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        @php( $deduction_subtotal = 0  )
                                        <td style="width: 50%; padding: 10px; background-color: #f9f9f9;vertical-align: baseline;">
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td colspan="2" style="font-weight: bold; padding: 10px; background-color: #dbdbdb;">Deductions</td>
                                                </tr>
                                                @foreach($payslip->salary->loans as $loan)
                                                    <?php
                                                        if($loan->type == 'fixed'){
                                                            $amount = $loan->amount; 
                                                        }else{
                                                            $amount = $loan->amount * $payslip->salary->salary / 100;
                                                        }
                                                        $deduction_subtotal += $amount;
                                                    ?>
                                                    <tr>
                                                        <td style="padding: 10px;">{{ $loan->title }}</td>
                                                        <td style="text-align: right;padding: 10px;">${{ $amount }}</td>
                                                    </tr>    
                                                @endforeach 
                                                <tr>
                                                    <td style="font-weight: bold;padding: 10px;">Total Deductions</td>
                                                    <td style="text-align: right; font-weight: bold;padding: 10px;">${{$deduction_subtotal}}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </table>
                        
                        <table style="width: 100%; margin-top: 20px;">
                            <tr>
                                <td style="padding: 10px;">
                                    Net Salary: <strong>$5 only</strong>
                                </td>
                            </tr>
                        </table>
                        
                            
                            
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>

</div>

@endSection

@section('script')
    

    <script>
        $(document).ready(function() {
           
        });
    </script>
@endsection