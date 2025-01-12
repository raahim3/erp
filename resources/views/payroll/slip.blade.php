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
                    <div class="table-responsive">
                        
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
           
        });
    </script>
@endsection