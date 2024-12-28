<?php

namespace App\DataTables;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('name', function ($query) {
                $profile = asset('default.jpg');
                if($query->profile){
                    $profile = asset('uploads/profile/' . $query->profile);
                }
                return '<img src="' . $profile . '" class="rounded-circle mx-2" width="40px" height="40px"> ' . $query->name;
            })
            ->addColumn('designation', function ($query) {
                return $query->designation->name;
            })
            ->addColumn('phone', function ($query) {
                return $query->phone ?? 'N/A';
            })
            ->addColumn('hired_at', function ($query) {
                return $query->hired_at ?? 'N/A';
            })
            ->addColumn('action', function ($query) {
                $en_id = Crypt::encrypt($query->id);
                $html = '<div class="d-flex gap-2">';
                if(auth()->user()->hasPermission('employees_attendance'))
                {
                    $html .= '<a href="'. route('attendance.employee', $en_id) .'" class="edit btn btn-primary btn-sm">Attendance</a>';
                }
                if(auth()->user()->hasPermission('employee_edit'))
                {
                    $html .= '<a href="'. route('employees.edit', $query->id) .'" class="edit btn btn-primary btn-sm">Edit</a>';
                }
                if(auth()->user()->hasPermission('employee_delete'))
                {
                    $html .= '<form action="'. route('employees.destroy', $query->id) .'" method="POST">
                                '. csrf_field() .
                                method_field('DELETE') .
                                    '<button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>';
                }
                $html .= '<div>';  
                            return $html;
            })
            ->rawColumns(['name', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('employee-table')
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
            Column::make('name'),
            Column::make('email'),
            Column::make('phone'),
            Column::make('designation'),
            Column::make('hired_at'),
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
        return 'Employee_' . date('YmdHis');
    }
}
