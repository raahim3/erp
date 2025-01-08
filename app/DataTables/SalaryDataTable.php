<?php

namespace App\DataTables;

use App\Models\Salary;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SalaryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($query){
                $encode_id = Crypt::encrypt($query->user_id);
                $html = '<div class="d-flex gap-2">';
                if(auth()->user()->hasPermission('employees_salary_history'))
                {
                    $html .= '<a class="btn btn-primary w-sm" href="'. route('salaries.history',$encode_id) .'"><i class="mdi mdi-history"></i> History</a>';
                }
                if(auth()->user()->hasPermission('give_increment_decrement'))
                {
                    $html .= '<a class="btn btn-primary btn-sm d-flex align-items-center gap-2 inc_dec_btn inc" data-salary="'.  $query->salary.'" data-user-id="'.$query->user_id.'" href="javascript:void(0);"><i class="mdi mdi-arrow-up"></i> Increment</a>';
                    $html .= '<a class="btn btn-primary btn-sm d-flex align-items-center gap-2 inc_dec_btn dec" data-salary="'.  $query->salary.'" data-user-id="'.$query->user_id.'" href="javascript:void(0);"><i class="mdi mdi-arrow-down"></i> Decrement</a>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('user', function ($query) {
                return '<div class="d-flex gap-3"><img src="' . profileImage($query->user->profile) . '" class="rounded-circle mx-2" width="40px" height="40px"><div><p>'. $query->user->name.'<span class="badge bg-primary d-block">'.$query->user->designation->name.'</span></p></div></div>';
            })
            ->addColumn('salary', function ($query) {
                return 'Rs '.number_format($query->salary, 2);
            })
            ->addColumn('email', function ($query) {
                return $query->user->email;
            })
            ->rawColumns(['action', 'user','email'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Salary $model): QueryBuilder
    {
        return $model->with('user')->where('status',1)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('salary-table')
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
            Column::make('user'),
            Column::make('email'),
            Column::make('effective_date'),
            Column::make('salary'),
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
        return 'Salary_' . date('YmdHis');
    }
}
