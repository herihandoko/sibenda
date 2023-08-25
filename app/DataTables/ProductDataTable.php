<?php

namespace App\DataTables;

use App\Models\Product;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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



            ->addColumn('image', function ($image) {

                $media = MediaImage($image->image, 1);
                $url = asset("$media");
                return '<img src=' . $url . ' border="0" width="100" class="img-rounded" align="center" />';

            })



            ->addColumn('created_at', function ($query) {
                return \Carbon\Carbon::parse($query->created_at)->format('M d - Y h:i a');
            })


            ->addColumn('category', function ($category) {
                return $category->getCategory ? $category->getCategory->name : '';
            })

            ->addColumn('action', function ($action) {
                $button = [
                    'edit' => [
                        'link' => route('admin.product.edit',  $action->id),
                        'permission' => 'product-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.product.destroy', $action->id),
                        'permission' => 'product-delete',
                    ]
                ];
                $button = json_decode(json_encode($button), FALSE);
                return view('admin.layouts.datatableButtons', compact('button'));
            })
            ->rawColumns(['image', 'created_at', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
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
                    ->setTableId('product-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),

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
            Column::make('name'),
            Column::make('image'),
            Column::make('stock'),
            Column::make('category'),
            Column::make('created_at'),
            Column::computed('action')
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
        return 'Product_' . date('YmdHis');
    }
}
