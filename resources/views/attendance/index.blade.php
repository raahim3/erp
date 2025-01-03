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
            <div class="col-xl-4 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cube-outline float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">Presents</h6>
                            <h2 class="mb-4 text-white" id="present">{{ $present_count }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-buffer float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">Absent</h6>
                            <h2 class="mb-4 text-white" id="absent">{{ $absent_count }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-tag-text-outline float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">On Leave</h6>
                            <h2 class="mb-4 text-white" id="leave">{{ $leave_count }}</h2>
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
                            <select name="employee" class="form-select" id="employee_filter">
                                <option value="all">All</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="">Date</label>
                            <input type="date" name="date" id="date_filter" class="form-control">
                        </div>
                        <div>
                            <label for="">Status</label>
                            <select name="status" class="form-select" id="status_filter">
                                <option value="all">All</option>
                                <option value="1">Present</option>
                                <option value="0">Absent</option>
                                <option value="2">On Leave</option>
                            </select>
                        </div>
                        <div>
                            <label for="">Behavior</label>
                            <select name="behavior" class="form-select" id="behavior_filter">
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
    <div class="modal fade" id="editAttendanceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
          <div class="modal-content">
                <form action="{{ route('attendances.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="is_edit" value="0">

                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Employee Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="">Employess</label>
                                <select name="employee" class="form-select" disabled id="edit_employee">
                                    @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Date</label>
                                <input type="date" name="date" id="edit_date" disabled class="form-control">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Punch In</label>
                                <input type="time" name="punch_in" id="edit_punch_in" class="form-control">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Punch Out</label>
                                <input type="time" name="punch_out" id="edit_punch_out" class="form-control">
                            </div>
                            
                            <div class="col-md-6 mt-3">
                                <label for="">Status</label>
                                <select name="status" class="form-select" id="edit_status">
                                    <option value="all">All</option>
                                    <option value="1">Present</option>
                                    <option value="0">Absent</option>
                                    <option value="2">On Leave</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Behavior</label>
                                <select name="behavior" class="form-select" id="edit_behavior">
                                    <option value="all">All</option>
                                    <option value="late">Late</option>
                                    <option value="early">Early</option>
                                    <option value="regular">Regular</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
          </div>
        </div>
      </div>
@endsection
@section('script')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function(){
            var dataTable = $('#attendance-table').DataTable();
            function reloadTable() {
                dataTable.ajax.reload();
            }

                // Attach change event to filters
                $('#employee_filter, #date_filter, #status_filter, #behavior_filter').on('change', function () {
                    reloadTable();
                });
            dataTable.on('preXhr.dt', function (e, settings, data) {
                data.employee_id = $('#employee_filter').val();
                data.date = $('#date_filter').val();
                data.status = $('#status_filter').val();
                data.behavior = $('#behavior_filter').val();
            });
            $(document).on('click','#refresh', function(){
                $('#refresh').html('<i class="mdi mdi-spin mdi-loading"></i> Refreshing...');

                $.ajax({
                    url: "{{ route('get.attendance.data') }}",
                    method: 'POST',
                    data:{
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        $('#present').html(response.present_count);
                        $('#absent').html(response.absent_count);
                        $('#leave').html(response.leave_count);
                        $('#attendance-table').DataTable().ajax.reload();
                        $('#refresh').html('<i class="mdi mdi-refresh"></i> Refresh');
                    }
                });
            });

            $(document).on('click','.edit_attendance', function(){
                var id = $(this).data('id');
                var date = $(this).data('date');
                var status = $(this).data('status');
                var behavior = $(this).data('behavior');
                var employee = $(this).data('employee');
                var punch_in = $(this).data('punch-in');
                var punch_out = $(this).data('punch-out');

                $('#edit_id').val(id);
                $('#edit_date').val(date);
                $('#edit_status').val(status);
                $('#edit_behavior').val(behavior);
                $('#edit_employee').val(employee);
                $('#edit_punch_in').val(punch_in);
                $('#edit_punch_out').val(punch_out);
                $('#editAttendanceModal').modal('show');
                // console.log(id);
                
            });
        });
    </script>
@endsection