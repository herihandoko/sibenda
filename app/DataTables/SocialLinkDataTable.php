<?php

namespace App\DataTables;

use App\Models\SocialLink;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SocialLinkDataTable extends DataTable
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
            ->addColumn('icon', function ($icon) {


                return '<i class="'.$icon->icon.'"></i>';

            })

            ->addColumn('action', function ($action) {
                $button = [
                    'edit' => [
                        'link' => route('admin.social-link.edit',  $action->id),
                        'permission' => 'social-link-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.social-link.destroy', $action->id),
                        'permission' => 'social-link-delete',
                    ]
                ];
                $button = json_decode(json_encode($button), FALSE);
                return view('admin.layouts.datatableButtons', compact('button'));
            })

            ->rawColumns(['action', 'icon']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SocialLink $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SocialLink $model)
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
                    ->setTableId('headersociallink-table')
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

            Column::make('id')->width(100),
            Column::make('icon'),
            Column::make('link'),

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
        return 'SocialLink_' . date('YmdHis');
    }
}
