<?php

namespace App\DataTables;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AttendanceDataTable extends DataTable
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
            return $query->punch_in ?? '-';
        })
        ->addColumn('punch_out', function ($query) {
            return $query->punch_out ?? '-';
        })
        ->addColumn('behavior', function ($query) {
            return '-';
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
        ->rawColumns(['employee','status'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Attendance $model): QueryBuilder
    {
        $company_id = auth()->user()->company_id;
        return $model->where('company_id', $company_id)->with('user')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('attendance-table')
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
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Attendance_' . date('YmdHis');
    }
}
