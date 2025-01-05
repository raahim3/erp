@extends('layouts.app')
@section('title','Salaries')

@section('content')

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>Salaries</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Payroll</a></li>
                    <li class="breadcrumb-item active">Salaries</li>
                </ol>
            </div>
        </div>
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

@include('payroll.salaries.change')

@section('script')
    {{ $dataTable->scripts() }}

    <script>
        $(document).ready(function() {
           $(document).on('click','.inc_dec_btn',function(){
                var salary = $(this).data('salary');
                var user_id = $(this).data('user-id');
                var type = "Increment";
                if($(this).hasClass('dec'))
                {
                    type = "Decrement";
                    $('#change_type_select').val('decrement');
                }else{
                    $('#change_type_select').val('increament');
                }
                $('#user_id').val(user_id);
                $('#effective_date').val(null);
                $('#change_type').text(type);
                $('#current_salary').text(salary);
                $('#salary').val(salary);
                $('#changeSalaryModal').modal('show'); 
           });
        });
    </script>
@endsection