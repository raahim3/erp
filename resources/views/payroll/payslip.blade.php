@extends('layouts.app')
@section('title','Payslips')

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
                    <li class="breadcrumb-item active">Payslips</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h2 class="card-title">Generate Payslips</h2>
                    <form class="col-md-6 d-flex gap-3" method="POST" action="{{ route('payslips.store') }}">
                        @csrf
                        <input type="month" required class="form-control" name="month_year">
                        
                        <button class="btn btn-primary">Generate</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>

</div>

@endSection

@section('script')
    {{ $dataTable->scripts() }}

    <script>
        $(document).ready(function() {
           
        });
    </script>
@endsection