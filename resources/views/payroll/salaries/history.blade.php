@extends('layouts.app')
@section('title','Salary History')

@section('content')
<style>
    .salary-box{
        border-left: 2px solid grey;
        padding: 0px 20px 20px 40px;
        position: relative;
    }
    .salary-list
    {
        margin-left: 100px
    }
    .salary_type{
        position: absolute;
        top: 0px;
        left: -27px;
        background-color: rgb(228, 228, 228);
        border-radius: 50%;
        padding: 10px 15px;
        font-size: 22px;
    }
    .salary_card{
        background-color: rgb(228, 228, 228);
        padding: 10px 15px;
        border-radius: 10px;
        /* font-size: 17px  ; */
        width: 300px;
    }
</style>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>History</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Payroll</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Salaries</a></li>
                    <li class="breadcrumb-item active">History</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Salary History</h3>
                    <div class="salary-list py-5">
                        @foreach ($salaries as $salary)
                            <div class="salary-box">
                                @if ($salary->type == 'increament')
                                    <i class="mdi mdi-arrow-up-bold text-success salary_type"></i>
                                    <div class="salary_card">
                                        <h5 class="text-capitalize">Salary Increment</h5>
                                        <p>Great news! Your salary has been increased to <strong>{{ $salary->salary }}</strong>. Keep up the excellent work!</p>
                                        <p class="m-0"><strong>Effected Date: </strong>{{ \Carbon\Carbon::parse($salary->effective_date)->format('d M Y') }}</p>
                                    </div>
                                @elseif ($salary->type == 'decrement')
                                    <i class="mdi mdi-arrow-down-bold text-danger salary_type"></i>
                                    <div class="salary_card">
                                        <h5 class="text-capitalize">Salary Adjustment</h5>
                                        <p>We regret to inform you that your salary has been adjusted to <strong>{{ $salary->salary }}</strong>. Please contact HR for more details.</p>
                                        <p class="m-0"><strong>Effected Date: </strong>{{ \Carbon\Carbon::parse($salary->effective_date)->format('d M Y') }}</p>
                                    </div>
                                @else
                                    <i class="mdi mdi-arrow-right-bold text-primary salary_type"></i>
                                    <div class="salary_card">
                                        <h5 class="text-capitalize">Salary Initial</h5>
                                        <p>Your salary has been set to <strong>{{ $salary->salary }}</strong>.</p>
                                        <p class="m-0"><strong>Effected Date: </strong>{{ \Carbon\Carbon::parse($salary->effective_date)->format('d M Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                    </div>
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
           
        })
    </script>
@endsection