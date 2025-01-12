<?php

namespace App\DataTables;

use App\Models\Payslip;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PayslipDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('employee', function($query){
                return '<div class="d-flex gap-3"><img src="' . profileImage($query->user->profile) . '" class="rounded-circle mx-2" width="40px" height="40px"><div><p>'. $query->user->name.'<span class="badge bg-primary d-block">'.$query->user->designation->name.'</span></p></div></div>';
            })
            ->addColumn('salary', function($query){
                return '$'.number_format($query->salary->salary, 2);
            })
            ->addColumn('net_salary', function($query){
                return '$'.number_format($query->net_salary, 2);
            })
            ->addColumn('status', function($query){
                if($query->status == 'paid')
                {
                    return '<span class="badge bg-success">Paid</span>';
                }
                else
                {
                    return '<span class="badge bg-danger">Unpaid</span>';
                }
            })
            ->addColumn('action', function($query){
                $html = '<div class="d-flex gap-2">';
                if($query->status == 'unpaid')
                {
                    $html .= '<a href="'. route('payslips.status.update', [$query->id , 'paid']) .'" class="btn btn-info btn-sm"><i class="mdi mdi-currency-usd" data-bs-toggle="tooltip" data-bs-placement="top" title="Pay Now"></i></a>';
                }
                $html .= '<a href="'. route('payslips.show', $query->id) .'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                $html .= '<form action="'. route('payslips.destroy', $query->id) .'" method="POST">
                    '. csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </form>';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['employee', 'action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Payslip $model): QueryBuilder
    {
        return $model->with('salary')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('payslip-table')
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
            Column::make('salary'),
            Column::make('net_salary'),
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
        return 'Payslip_' . date('YmdHis');
    }
}
