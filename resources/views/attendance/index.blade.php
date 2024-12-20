@extends('layouts.app')
@section('title','Attendance')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4>Attendance</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Attendance</a></li>
                        <li class="breadcrumb-item active">Attendance</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <button class="btn btn-primary" id="refresh"><i class="mdi mdi-refresh"></i> Refresh</button>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cube-outline float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">Presents</h6>
                            <h2 class="mb-4 text-white">0</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-buffer float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">Absent</h6>
                            <h2 class="mb-4 text-white">0</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-tag-text-outline float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">On Leave</h6>
                            <h2 class="mb-4 text-white">0</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-briefcase-check float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">Un Informed</h6>
                            <h2 class="mb-4 text-white">0</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="card-title">Attendance</h2>
                    <div class="d-flex gap-2">
                        <div>
                            <label for="">Employees</label>
                            <select name="status" class="form-select" id="">
                                <option value="all">All</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="">Date</label>
                            <input type="date" name="" id="" class="form-control">
                        </div>
                        <div>
                            <label for="">Status</label>
                            <select name="status" class="form-select" id="">
                                <option value="all">All</option>
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="leave">On Leave</option>
                                <option value="uninformed">Un Informed</option>
                            </select>
                        </div>
                        <div>
                            <label for="">Behavior</label>
                            <select name="status" class="form-select" id="">
                                <option value="all">All</option>
                                <option value="late">Late</option>
                                <option value="early">Early</option>
                                <option value="regular">Regular</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function(){
            $(document).on('click','#refresh', function(){
                $('#refresh').html('<i class="mdi mdi-spin mdi-loading"></i> Refreshing...');
                $('#attendance-table').DataTable().ajax.reload();
                setTimeout(() => {
                    $('#refresh').html('<i class="mdi mdi-refresh"></i> Refresh');
                }, 1000);
            });
        });
    </script>
@endsection