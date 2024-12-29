@extends('layouts.app')
@section('title','Leave Types')

@section('content')

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>Leave Types</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Leave Types</li>
                </ol>
            </div>
        </div>
        @if (auth()->user()->hasPermission('leave_type_create'))
            <div class="col-sm-6">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#createTypeModal" class="btn btn-primary float-end"><i class="mdi mdi-plus me-1"></i> Add New Type</a>
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
@if (auth()->user()->hasPermission('leave_type_create'))
    @include('leave_types.create')
@endif

@if (auth()->user()->hasPermission('leave_type_edit'))
    @include('leave_types.edit')
@endif

@endSection

@section('script')
    {{ $dataTable->scripts() }}

    <script>
        $(document).ready(function() {
            $(document).on('click','.edit_leave_type',function(){
                var id = $(this).data('id');
                var title = $(this).data('title');
                var status = $(this).data('status');
                var form_url = "{{ route('leave_types.update', ':id') }}";
                form_url = form_url.replace(':id', id);
                $('#editTypeForm').attr('action', form_url);
                $('#edit_title').val(title);
                $('#edit_status').val(status);
                $('#editTypeModal').modal('show');
            });
        })
    </script>
@endsection