<?php

namespace App\DataTables;

use App\Models\FooterContactItem;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FooterContactItemDataTable extends DataTable
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
                        'link' => route('admin.footer-contact-item.edit',  $action->id),
                        'permission' => 'footer-contact-item-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.footer-contact-item.destroy', $action->id),
                        'permission' => 'footer-contact-item-delete',
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
     * @param \App\Models\FooterContactItem $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FooterContactItem $model)
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
                    ->setTableId('footercontactitem-table')
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

            Column::make('id') ->width(100),
            Column::make('name'),
            Column::make('icon'),
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
        return 'FooterContactItem_' . date('YmdHis');
    }
}
