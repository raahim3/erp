<?php

namespace App\DataTables;

use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LeaveTypeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function ($query) {
            $html = '<div class="d-flex gap-2">';
                if(auth()->user()->hasPermission('leave_type_edit'))
                {
                    $html .= '<a href="javascript:void(0)" data-id="' . $query->id . '" data-title="' . $query->title . '" data-status="' . $query->status . '" class="edit btn btn-primary btn-sm edit_leave_type">Edit</a>';
                }
                if(auth()->user()->hasPermission('leave_type_delete'))
                {
                    $html .= '<form action="'. route('leave_types.destroy', $query->id) .'" method="POST">
                        '. csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>';
                }
            $html .= '<div>';  
            return $html;
        })
        ->addColumn('status', function ($query) {
            if($query->status == 1)
            {
                return '<span class="badge bg-success">Active</span>';
            }
            else
            {
                return '<span class="badge bg-danger">Inactive</span>';
            }
        })
        ->rawColumns(['status','action'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(LeaveType $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('leavetype-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('title'),
            Column::make('status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'LeaveType_' . date('YmdHis');
    }
}
