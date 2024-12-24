<?php

namespace App\DataTables;

use App\Models\Attendance;
use App\Models\EmployeeAttendance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeeAttendanceDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('employee', function ($query) {
            $profile = asset('default.jpg');
            if($query->user->profile){
                $profile = asset('uploads/profile/' . $query->user->profile);
            }
            return '<img src="' . $profile . '" class="rounded-circle mx-2" width="40px" height="40px"> ' . $query->user->name;
        })
        ->addColumn('production_time', function ($query) {
            return $query->production_time ?? '-';
        })
        ->addColumn('punch_in', function ($query) {
            return $query->punch_in ? Carbon::parse($query->punch_in)->format('h:i:s A') : '-';
        })
        ->addColumn('punch_out', function ($query) {
            return $query->punch_out ? Carbon::parse($query->punch_out)->format('h:i:s A') : '-';
        })
        ->addColumn('date', function ($query) {
            return Carbon::parse($query->date)->format('d M Y');
        })
        ->addColumn('behavior', function ($query) {
            switch ($query->punch_in_behavior) {
                case 'late':
                    return '<span class="badge bg-danger">Late</span>';
                    break;
                case 'regular':
                    return '<span class="badge bg-success">Regular</span>';
                    break;
                case 'early':
                    return '<span class="badge bg-warning">Early</span>';
                    break;
                default:
                    return '-';
                    break;
            }
        })
        ->addColumn('status', function ($query) {
            switch ($query->status) {
                case 0 :
                    return '<span class="badge bg-danger">Absent</span>';
                    break;
                case 1 :
                    return '<span class="badge bg-success">Present</span>';
                    break;
                case 2 :
                    return '<span class="badge bg-warning">Leave</span>';
                    break;
            }
        })
        ->addColumn('action', function ($query) {
            return '<a href="javascript:void(0)" data-id="' . $query->id . '" data-date="' . $query->date . '" data-status="' . $query->status . '" data-behavior="' . $query->punch_in_behavior . '" data-employee="' . $query->user->name . '" data-punch-in="' . $query->punch_in . '" data-punch-out="' . $query->punch_out . '" class="edit btn btn-primary btn-sm edit_attendance">Edit</a>';
        })
        ->rawColumns(['employee','status','behavior' ,'action'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Attendance $model): QueryBuilder
    {
        $emp_id = $this->employee_id;
        return $model->where('user_id', $emp_id)->whereMonth('created_at', Carbon::now()->month)->latest()->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('employeeattendance-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('employee'),
            Column::make('date'),
            Column::make('punch_in'),
            Column::make('punch_out'),
            Column::make('production_time'),
            Column::make('status'),
            Column::make('behavior'),
            Column::make('action'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'EmployeeAttendance_' . date('YmdHis');
    }
}
