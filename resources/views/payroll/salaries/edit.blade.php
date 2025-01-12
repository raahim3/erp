@extends('layouts.app')
@section('title','Edit Salary')

@section('content')
<style>
    .table-responsive {
        height: 300px;
    }
</style>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>Edit Salary</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Payroll</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Salaries</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-6 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Allowance</h4>
                        <a href="javascript:void(0);" class="btn btn-primary create_edit_allowance" ><i class="mdi mdi-plus"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-3">
                            <tr>
                                <th>Employee</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            @forelse ($allowances as $allowance)
                                <tr>
                                    <td>{{ $allowance->user->name }}</td>
                                    <td>{{ $allowance->title }}</td>
                                    <td>{{ $allowance->type }}</td>
                                    <td>{{ $allowance->amount }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="javascript:void(0);" class="btn btn-primary create_edit_allowance" data-id="{{ $allowance->id }}" data-title="{{ $allowance->title }}" data-type="{{ $allowance->type }}" data-amount="{{ $allowance->amount }}"><i class="mdi mdi-pencil"></i></a>
                                        <form action="{{ route('allowances.destroy',$allowance->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No allowance found</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Commission</h4>
                        <a href="javascript:void(0);" class="btn btn-primary create_edit_commission"><i class="mdi mdi-plus"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-3">
                            <tr>
                                <th>Employee</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            @forelse ($commissions as $commission)
                                <tr>
                                    <td>{{ $commission->user->name }}</td>
                                    <td>{{ $commission->title }}</td>
                                    <td>{{ $commission->type }}</td>
                                    <td>{{ $commission->amount }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="javascript:void(0);" class="btn btn-primary create_edit_commission" data-id="{{ $commission->id }}" data-title="{{ $commission->title }}" data-type="{{ $commission->type }}" data-amount="{{ $commission->amount }}"><i class="mdi mdi-pencil"></i></a>
                                        <form action="{{ route('commissions.destroy',$commission->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No allowance found</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Loan</h4>
                        <a href="javascript:void(0);" class="btn btn-primary create_edit_loan"><i class="mdi mdi-plus"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-3">
                            <tr>
                                <th>Employee</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            @forelse ($loans as $loan)
                                <tr>
                                    <td>{{ $loan->user->name }}</td>
                                    <td>{{ $loan->title }}</td>
                                    <td>{{ $loan->type }}</td>
                                    <td>{{ $loan->amount }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="javascript:void(0);" class="btn btn-primary create_edit_commission" data-id="{{ $loan->id }}" data-title="{{ $loan->title }}" data-type="{{ $loan->type }}" data-amount="{{ $loan->amount }}"><i class="mdi mdi-pencil"></i></a>
                                        <form action="{{ route('commissions.destroy',$loan->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No loan found</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Overtime</h4>
                        <a href="javascript:void(0);" class="btn btn-primary create_edit_overtime"><i class="mdi mdi-plus"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-3">
                            <tr>
                                <th>Employee</th>
                                <th>Title</th>
                                <th>Days</th>
                                <th>Hours</th>
                                <th>Rate</th>
                                <th>Action</th>
                            </tr>
                            @forelse ($overtimes as $overtime)
                                <tr>
                                    <td>{{ $overtime->user->name }}</td>
                                    <td>{{ $overtime->title }}</td>
                                    <td>{{ $overtime->days }}</td>
                                    <td>{{ $overtime->hours }}</td>
                                    <td>{{ $overtime->rate }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="javascript:void(0);" class="btn btn-primary create_edit_overtime" data-id="{{ $overtime->id }}" data-title="{{ $overtime->title }}" data-days="{{ $overtime->days }}" data-hours="{{ $overtime->hours }} " data-rate="{{ $overtime->rate }}"><i class="mdi mdi-pencil"></i></a>
                                        <form action="{{ route('overtime.destroy',$overtime->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No overtime found</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('payroll.salaries.allowance.create')
@include('payroll.salaries.commission.create')
@include('payroll.salaries.loan.create')
@include('payroll.salaries.overtime.create')

@endSection

@section('script')
    <script>
        $(document).ready(function() {
           $(document).on('click','.create_edit_allowance',function(){
                var id = $(this).data('id');
                var url = "{{ route('allowances.store') }}";
                var heading = "Create Allowance";
                var title = $(this).data('title');
                var type = $(this).data('type');
                var amount = $(this).data('amount');
                var button = "Create";
                var method = "";
                $('#allowance_methed').attr('name', 're');
                if(id){
                    $('#allowance_methed').attr('name', '_method');
                    url = "{{ route('allowances.update',':id') }}";
                    url = url.replace(':id',id);
                    heading = "Edit Allowance";
                    button = "Update";
                    method = "PUT";
                }
                $('#allowance_methed').val(method);
                $('#allowance_title').val(title);
                $('#allowance_type').val(type);
                $('#allowance_amount').val(amount);
                $('#allowanceForm').attr('action', url);
                $('#allowanceModalLabel').text(heading);
                $('#allowanceSubmit').text(button);
                $('#createAllowanceModal').modal('show');
            });
           $(document).on('click','.create_edit_commission',function(){
                var id = $(this).data('id');
                var url = "{{ route('commissions.store') }}";
                var heading = "Create Commission";
                var title = $(this).data('title');
                var type = $(this).data('type');
                var amount = $(this).data('amount');
                var button = "Create";
                var method = "";
                $('#commission_methed').attr('name', 're');
                if(id){
                    $('#commission_methed').attr('name', '_method');
                    url = "{{ route('commissions.update',':id') }}";
                    url = url.replace(':id',id);
                    heading = "Edit Commission";
                    button = "Update";
                    method = "PUT";
                }
                $('#commission_methed').val(method);
                $('#commission_title').val(title);
                $('#commission_type').val(type);
                $('#commission_amount').val(amount);
                $('#commissionForm').attr('action', url);
                $('#commissionModalLabel').text(heading);
                $('#commissionSubmit').text(button);
                $('#createCommissionModal').modal('show');
            });
           $(document).on('click','.create_edit_loan',function(){
                var id = $(this).data('id');
                var url = "{{ route('loans.store') }}";
                var heading = "Create Loan";
                var title = $(this).data('title');
                var type = $(this).data('type');
                var amount = $(this).data('amount');
                var button = "Create";
                var method = "";
                $('#loan_methed').attr('name', 're');
                if(id){
                    $('#loan_methed').attr('name', '_method');
                    url = "{{ route('loans.update',':id') }}";
                    url = url.replace(':id',id);
                    heading = "Edit Loan";
                    button = "Update";
                    method = "PUT";
                }
                $('#loan_methed').val(method);
                $('#loan_title').val(title);
                $('#loan_type').val(type);
                $('#loan_amount').val(amount);
                $('#loanForm').attr('action', url);
                $('#loanModalLabel').text(heading);
                $('#loanSubmit').text(button);
                $('#createLoanModal').modal('show');
            });
            
           $(document).on('click','.create_edit_overtime',function(){
                var id = $(this).data('id');
                var url = "{{ route('overtime.store') }}";
                var heading = "Create Overtime";
                var title = $(this).data('title');
                var days = $(this).data('days');
                var hours = $(this).data('hours');
                var rate = $(this).data('rate');
                var button = "Create";
                var method = "";
                $('#overtime_methed').attr('name', 're');
                if(id){
                    $('#overtime_methed').attr('name', '_method');
                    url = "{{ route('overtime.update',':id') }}";
                    url = url.replace(':id',id);
                    heading = "Edit Overtime";
                    button = "Update";
                    method = "PUT";
                }
                console.log(hours);
                
                $('#overtime_methed').val(method);
                $('#overtime_title').val(title);
                $('#overtime_days').val(days);
                $('#overtime_hour').val(hours);
                $('#overtime_rate').val(rate);
                $('#overtimeForm').attr('action', url);
                $('#overtimeModalLabel').text(heading);
                $('#overtimeSubmit').text(button);
                $('#createOvertimeModal').modal('show');
            });
        })
    </script>
@endsection