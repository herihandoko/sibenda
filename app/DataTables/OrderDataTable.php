<?php

namespace App\DataTables;

use App\Models\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function($action){

                $button = [
                    'show' => [
                        'link' => route('admin.order.show',  $action->id),
                        'permission' => 'order-delete',
                    ],
                    'delete' => [
                        'link' => route('admin.order.destroy', $action->id),
                        'permission' => 'order-delete',
                    ]
                ];

                $button = json_decode(json_encode($button), FALSE);
                return view('admin.layouts.datatableButtons', compact('button'));
            })

            ->addColumn('items', function($order){
                return view('admin.OrderItem', compact('order'));
            })

            ->addColumn('total_amount', function($action){
                return numberFormat($action->total_amount).' '.$action->transaction->currency;
            })

            ->addColumn('status', function ($status) {
                if ($status->status !== 'complete') {
                    return '<div class="btn btn-danger btn-sm"> '.$status->status.' </div>';
                }
                else return '<div class="btn btn-secondary btn-sm"> '.$status->status.' </div>';

            })
            ->rawColumns(['status' ,'action','items','total_amount']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('order-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(

                        Button::make('reset'),

                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [

            Column::make('id')->width(100),
            Column::make('items'),
            Column::make('status') ->width(100),
            Column::make('total_amount') ->width(100),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(150)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Order_' . date('YmdHis');
    }
}
