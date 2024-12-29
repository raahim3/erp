@extends('layouts.app')
@section('title','Leave Requests')

@section('content')

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>Leave Requests</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Leave Requests</li>
                </ol>
            </div>
        </div>
        @if (auth()->user()->hasPermission('leave_create'))
            <div class="col-sm-6">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#createLeaveModal" class="btn btn-primary float-end"><i class="mdi mdi-plus me-1"></i> Add Leave</a>
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
@if (auth()->user()->hasPermission('leave_create'))
    @include('leave_requests.create')
@endif

@if (auth()->user()->hasPermission('leave_type_edit'))
    @include('leave_requests.edit')
@endif

@if (auth()->user()->hasPermission('leave_type_read'))
    @include('leave_requests.show')
@endif

@endSection

@section('script')
    {{ $dataTable->scripts() }}

    <script>
        $(document).ready(function() {
            $(document).on('click','.edit_leave',function(){
                var id = $(this).data('id');
                var employee = $(this).data('employee');
                var start_date = $(this).data('start-date');
                var end_date = $(this).data('end-date');
                var reason = $(this).data('reason');
                var status = $(this).data('status');
                var form_url = "{{ route('leave_requests.update', ':id') }}";
                form_url = form_url.replace(':id', id);
                $('#editLeaveForm').attr('action', form_url);
                $('#edit_employee').val(employee);
                $('#edit_start_date').val(start_date);
                $('#edit_end_date').val(end_date);
                $('#edit_reason').val(reason);
                $('#edit_status').val(status);
                $('#editLeaveModal').modal('show');
            });
            $(document).on('click','.view_leave',function(){
                var data = $(this).data('data');
                var image = $(this).data('profile');
                var status = 'Pending';
                if(data.status == '1')
                {
                    status = 'Approved';   
                }else if(data.status == '2')
                {
                    status = 'Rejected';
                }else{
                    status = 'Pending';
                    var approve_url = "{{ route('leave_requests.change_status', [':id' , '1']) }}";
                    var reject_url = "{{ route('leave_requests.change_status', [':id' , '2']) }}";
                    $('#approveBtn').attr('href', approve_url.replace(':id', data.id));
                    $('#rejectBtn').attr('href', reject_url.replace(':id', data.id));
                    $('#showButtons').removeClass('d-none').addClass('d-flex');
                }
                $('#showImage').attr('src', image);
                $('#showName').text(data.user.name);
                $('#showStatus').text(status);
                $('#showStartDate').text(data.start_date);
                $('#showEndDate').text(data.end_date);
                $('#showReason').text(data.reason);
                $('#LeaveModal').modal('show');
            });
        })
    </script>
@endsection