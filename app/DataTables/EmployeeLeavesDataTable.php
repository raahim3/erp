<?php

namespace App\DataTables;

use App\Models\EmployeeLeafe;
use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeeLeavesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('leave_type', function($query){
                return $query->leave_type->title;
            })
            ->addColumn('start_date', function($query){
                return date('d M Y', strtotime($query->start_date));
            })
            ->addColumn('end_date', function($query){
                return date('d M Y', strtotime($query->end_date));
            })
            ->addColumn('status', function($query){
                switch ($query->status) {
                    case '0':
                        return '<span class="badge bg-warning">Pending</span>';
                        break;
                    case '1':
                        return '<span class="badge bg-success">Approved</span>';
                        break;
                    default:
                        return '<span class="badge bg-danger">Rejected</span>';
                        break;
                }
            })
            ->rawColumns(['action', 'employee', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(LeaveRequest $model): QueryBuilder
    {
        return $model->where('user_id',$this->employee_id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('employeeleaves-table')
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
            Column::make('leave_type'),
            Column::make('start_date'),
            Column::make('end_date'),
            Column::make('status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'EmployeeLeaves_' . date('YmdHis');
    }
}
