@extends('layouts.app')
@section('title','Employees')

@section('content')

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>Employees</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employees</li>
                </ol>
            </div>
        </div>
        @if (auth()->user()->hasPermission('employee_create'))
            <div class="col-sm-6">
                <a href="{{ route('employees.create') }}" class="btn btn-primary float-end"><i class="mdi mdi-plus me-1"></i> Add New Employee</a>
            </div>
        @endif
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>

</div>

@endSection

@section('script')
    {{ $dataTable->scripts() }}
@endsection