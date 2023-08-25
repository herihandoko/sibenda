<?php

namespace App\DataTables;

use App\Models\ShopSlider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ShopSliderDataTable extends DataTable
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
            ->addColumn('foreground', function ($image) {

                $media = MediaImage($image->foreground, 1);
                $url = asset("$media");
                return '<img src=' . $url . ' border="0" width="100" class="img-rounded" align="center" />';

            })

            ->addColumn('background', function ($image) {

                $media = MediaImage($image->background, 1);
                $url = asset("$media");
                return '<img src=' . $url . ' border="0" width="100" class="img-rounded" align="center" />';

            })


            ->addColumn('action', function ($action) {

                $button = [
                    'edit' => [
                        'link' => route('admin.shop-slider.edit',  $action->id),
                        'permission' => 'shop-slider-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.shop-slider.destroy', $action->id),
                        'permission' => 'shop-slider-delete',
                    ]
                ];

                $button = json_decode(json_encode($button), FALSE);
                return view('admin.layouts.datatableButtons', compact('button'));

            })

            ->rawColumns(['action', 'background', 'foreground']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ShopSlider $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ShopSlider $model)
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
                    ->setTableId('shopslider-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('reset')
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


            Column::make('main_heading'),
            Column::make('foreground'),
            Column::make('background'),
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
        return 'ShopSlider_' . date('YmdHis');
    }
}
