@extends('layouts.app')
@section('title','Attendance')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body d-flex flex-column align-items-center">
                        @php
                            $message = 'Good morning';
                        @endphp
                        <p class="text-muted mb-1 text-center fw-bold text-sm">{{ $greeting }} , {{ $user->first_name }} </p>
                        <h5 class="text-center mb-2 fw-bold">{{ date('g:i A').', '.date('d M Y')  }} </h5>
                        <img src="{{ profileImage($user->profile) }}" width="120px" height="120px" alt="{{ $user->name }}" class="rounded-circle">
                        <span class="badge bg-success w-100 py-2 fs-6 mt-3">Production Time : {{ $production_time }}</span>
                        <span class="my-2">Punch In : {{ $punch_in_time }}</span>
                        <button class="btn btn-primary w-100" data-id="{{ $is_punch_in ? 0 : 1 }}" id="punch_in_out">{{ $is_punch_in ? 'Punch Out' : "Punch In" }}</button>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <i class="mdi mdi-clock-outline fs-2 bg-primary text-white py-1 px-2 rounded"></i>
                                <div class="d-flex justify-content-between">
                                    <h4 class="mt-3 mb-0 fw-bold">Total Hours Today</h4>
                                    <h4 class="mt-3 mb-0">{{ number_format($today_working_hours , 1) }} <span class="mx-1">/</span> {{ number_format($total_shift_hour) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <i class="mdi mdi-clock-outline bg-info fs-2 text-white py-1 px-2 rounded"></i>
                                <div class="d-flex justify-content-between">
                                    <h4 class="mt-3 mb-0 fw-bold">Total Hours Week</h4>
                                    <h4 class="mt-3 mb-0">{{ number_format($week_working_hours , 1) }} <span class="mx-1">/</span> {{ number_format($total_shift_week_hour) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <i class="mdi mdi-clock-outline fs-2 bg-warning text-white py-1 px-2 rounded"></i>
                                <div class="d-flex justify-content-between">
                                    <h4 class="mb-0 mt-3 fw-bold">Total Hours Month</h4>
                                    <h4 class="mt-3 mb-0">{{ number_format($month_working_hours , 1) }} <span class="mx-1">/</span> {{ number_format($total_shift_month_hour) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <i class="mdi mdi-clock-outline fs-2 bg-success text-white py-1 px-2 rounded"></i>
                                <div class="d-flex justify-content-between">
                                    <h4 class="mt-3 mb-0 fw-bold">Overtime this month</h4>
                                    <h4 class="mt-3 mb-0">10 <span class="mx-1">/</span> 20</h4>
                                </div>
                            </div>
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
                        <div class="mb-0">
                            <label>Date </label>
                            <div>
                                <div class="input-daterange input-group" id="datepicker4" data-date-format="dd/mm/yyyy"  data-date-autoclose="true"  data-provide="datepicker" data-date-container='#datepicker4'>
                                    <input type="text" class="form-control" id="start_date" name="start" placeholder="Start date" />
                                    <input type="text" class="form-control" id="end_date" name="end" placeholder="End date" />
                                </div>
                            </div>
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
                    <input type="hidden" name="is_edit" value="1">

                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Employee Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="">Employess</label>
                                <input name="employee" class="form-control" disabled id="edit_employee"/>
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
            var dataTable = $('#employeeattendance-table').DataTable();
            function reloadTable() {
                dataTable.ajax.reload();
            }

                // Attach change event to filters
                $('#start_date, #end_date, #status_filter, #behavior_filter').on('change', function () {
                    reloadTable();
                });
            dataTable.on('preXhr.dt', function (e, settings, data) {
                data.start_date = $('#start_date').val();
                data.end_date = $('#end_date').val();
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
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            const formatDate = (date) => {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0'); 
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            };
            $('input[name="start"]').val(formatDate(firstDay));
            $('input[name="end"]').val(formatDate(lastDay));
        });
    </script>
@endsection