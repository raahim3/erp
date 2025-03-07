<?php

namespace App\DataTables;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
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
                    if(auth()->user()->hasPermission('role_permissions'))
                    {
                        $html .= '<a href="'. route('roles.permissions', $query->id) .'" class="edit btn btn-primary btn-sm">Permissions</a>';
                    }
                    if(auth()->user()->hasPermission('role_edit'))
                    {
                        $html .= '<a href="'. route('roles.edit', $query->id) .'" class="edit btn btn-primary btn-sm">Edit</a>';
                    }
                    if(auth()->user()->hasPermission('role_delete') && $query->is_default == 0)
                    {
                        $html .= '<form action="'. route('roles.destroy', $query->id) .'" method="POST">
                            '. csrf_field() . method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>';
                    }
                $html .= '<div>';  
                return $html;
            })
            
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        $company_id = auth()->user()->company_id;
        return $model->where('company_id', $company_id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('role-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle();
                    // ->buttons([
                    //     Button::make('excel'),
                    //     Button::make('csv'),
                    //     Button::make('pdf'),
                    //     Button::make('print')
                    // ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
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
        return 'Role_' . date('YmdHis');
    }
}
