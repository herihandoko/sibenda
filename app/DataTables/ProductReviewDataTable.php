<?php

namespace App\DataTables;

use App\Models\ProductReview;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductReviewDataTable extends DataTable
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
            ->addColumn('action', function ($action) {

                $button = [
                    'hide' => [
                        'status' => $action->status,
                        'link' => route('admin.product-review.edit',  $action->id),
                        'permission' => 'product-review-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.product-review.destroy', $action->id),
                        'permission' => 'product-review-delete',
                    ]
                ];
                $button = json_decode(json_encode($button), FALSE);
                return view('admin.layouts.datatableButtons', compact('button'));

            })
            ->addColumn('customer_name', function ($customer_name) {
                return $customer_name->customer->name;
            })
            ->addColumn('rating', function ($rating) {
                $star = null;
                for ($i = 0; $i < $rating->rating; $i++) {
                    $star .= '<i class="fas fa-star    "></i>';
                }
                return $star;
            })
            ->addColumn('created_at', function ($query) {
                return \Carbon\Carbon::parse($query->created_at)->format('M d - Y h:i a');
            })
            ->addColumn('product', function ($product) {

                return view('admin.reviewProduct', compact('product'));
            })
            ->rawColumns(['status', 'action', 'customer_name', 'rating', 'product']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ProductReview $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ProductReview $model)
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
            ->setTableId('productreview-table')
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
            Column::make('id'),
            Column::make('rating')->width(100),
            Column::make('comment'),
            Column::make('product'),
            Column::make('customer_name')->width(150),
            Column::make('created_at')->width(100)->title('Date'),
            Column::make('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
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
        return 'ProductReview_' . date('YmdHis');
    }
}
