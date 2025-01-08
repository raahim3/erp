@extends('layouts.app')
@section('title','Holidays')

@section('content')

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>Holidays</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Holidays</li>
                </ol>
            </div>
        </div>
        @if (auth()->user()->hasPermission('holiday_create'))
            <div class="col-sm-6">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#createHolidayModal" class="btn btn-primary float-end"><i class="mdi mdi-plus me-1"></i> Add Holiday</a>
            </div>
        @endif
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>

</div>

@if (auth()->user()->hasPermission('holiday_create'))
    @include('holidays.create')
@endif
@if (auth()->user()->hasPermission('holiday_edit'))
    @include('holidays.edit')
@endif
@include('holidays.show')

@endSection

@section('script')

    <script>
        $(document).ready(function() {
            const calendarEl = document.getElementById('calendar')
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            })
            calendar.render();
            calendar.addEventSource({
                events: [
                    @foreach ($holidays as $holiday)
                        {
                            title: "{{ $holiday->title }}",
                            start: "{{ $holiday->date }}",
                            end: "{{ $holiday->date }}",
                            color: "{{ $holiday->status == 0 ? '#dc3545' : '#28a745' }}",
                            classNames: ["holiday-item" , "id-{{ $holiday->id }}"],
                            @if (auth()->user()->hasPermission('holiday_edit'))
                                url: "javascript:void(0);",
                            @endif
                        },
                    @endforeach
                ]
            });

            $(document).on('click', '.holiday-item', function() {
                const id = $(this).hasClass('holiday-item') ? $(this).attr('class').split(' ').find(cls => cls.startsWith('id-')).replace('id-', '') : null;
                
                if (id) {
                    $.ajax({
                        url: "{{ route('holidays.show', ':id') }}".replace(':id', id),
                        method: 'get',
                        success: function(response) {
                            console.log(response);
                            $('.holidayTitle').text(response.title);
                            $('.holidayDate').text(response.date);
                            var status = response.status == 0 ? 'Inactive' : (  response.status == 1 ? 'Active' : 'Completed' );
                            $('.holidayStatus').text(status);
                            $('.holidayDescription').text(response.description);
                            $('#editHoliday').data('data',response);
                            $('#showHolidayModal').modal('show');
                        }
                    });
                }
            });

            $(document).on('click','.edit_holiday',function(){
                var data = $(this).data('data');
                $('#showHolidayModal').modal('hide');
                $('#holiday_id').val(data.id);
                $('#edit_title').val(data.title);
                $('#edit_date').val(data.date);
                $('#edit_status').val(data.status);
                $('#edit_description').val(data.description);
                $('#editHolidayForm').attr('action', "{{ route('holidays.update', ':id') }}".replace(':id', data.id));
                $('#deleteHolidayForm').attr('action', "{{ route('holidays.destroy', ':id') }}".replace(':id', data.id));
                $('#editHolidayModal').modal('show');
            });
        })
    </script>
@endsection