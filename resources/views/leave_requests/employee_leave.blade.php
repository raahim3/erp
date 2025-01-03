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
        @if (auth()->user()->hasPermission('apply_leaves'))
            <div class="col-sm-6">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#applyLeaveModal" class="btn btn-primary float-end"><i class="mdi mdi-plus me-1"></i> Apply Leave</a>
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
@if (auth()->user()->hasPermission('apply_leaves'))
    @include('leave_requests.apply')
@endif

@endSection

@section('script')
    {{ $dataTable->scripts() }}

    <script>
        $(document).ready(function() {
            
        })
    </script>
@endsection