<?php

namespace App\DataTables;

use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LeaveRequestDataTable extends DataTable
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
                    if(auth()->user()->hasPermission('leave_read'))
                    {
                        $html .= "<a href='javascript:void(0)' data-data='" . $query . "' data-profile='". profileImage($query->profile) ."'  class='edit btn btn-primary btn-sm view_leave'>View</a>";
                    }
                    if(auth()->user()->hasPermission('leave_edit'))
                    {
                        $html .= '<a href="javascript:void(0)" data-id="' . $query->id . '" data-employee="' . $query->user_id . '" data-status="' . $query->status . '" data-start-date="' . $query->start_date . '" data-end-date="' . $query->end_date . '" data-reason="' . $query->reason . '" class="edit btn btn-primary btn-sm edit_leave">Edit</a>';
                    }
                    if(auth()->user()->hasPermission('leave_delete'))
                    {
                        $html .= '<form action="'. route('leave_requests.destroy', $query->id) .'" method="POST">
                            '. csrf_field() . method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>';
                    }
                $html .= '<div>';  
                return $html;
            })
            ->addColumn('employee', function($query){
                return '<img src="'. profileImage($query->profile) .'" class="rounded-circle mx-2" width="40px" height="40px">'.$query->user->name;
            })
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
        return $model->with('user')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('leaverequest-table')
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
            Column::make('leave_type'),
            Column::make('start_date'),
            Column::make('end_date'),
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
        return 'LeaveRequest_' . date('YmdHis');
    }
}
