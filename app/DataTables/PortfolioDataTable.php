<?php

namespace App\DataTables;

use App\Models\Portfolio;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PortfolioDataTable extends DataTable
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

            ->addColumn('action', function ($action) {

                $button = [
                    'edit' => [
                        'link' => route('admin.portfolio.edit',  $action->id),
                        'permission' => 'portfolio-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.portfolio.destroy', $action->id),
                        'permission' => 'portfolio-delete',
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
     * @param \App\Models\Portfolio $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Portfolio $model)
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
            ->setTableId('portfolio-table')
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
            Column::make('title'),
            Column::make('image'),
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
        return 'Portfolio_' . date('YmdHis');
    }
}
