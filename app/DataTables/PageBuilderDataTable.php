<?php

namespace App\DataTables;

use App\Models\PageBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PageBuilderDataTable extends DataTable
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
            ->addColumn('link', function ($action) {
                return '

                <div class="input-group mb-3">
                <input type="text" class="form-control" data-input="'.url("$action->slug").'" value="'.url("$action->slug").'"/>
                <div class="input-group-append">
                  <button data-button="'.url("$action->slug").'" class="btn btn-outline-secondary copy" type="button">
                  <i class="fas fa-paperclip    "></i> Copy</button>
                </div>
              </div>
              ';
            })
            ->addColumn('action', function ($action) {

                $button = [
                    'edit' => [
                        'link' => route('admin.page-builder.edit',  $action->id),
                        'permission' => 'page-builder-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.page-builder.destroy', $action->id),
                        'permission' => 'page-builder-delete',
                    ]
                ];
                $button = json_decode(json_encode($button), FALSE);
                return view('admin.layouts.datatableButtons', compact('button'));

            })
            ->rawColumns(['action', 'link']);
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PageBuilder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PageBuilder $model)
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
            ->setTableId('pagebuilder-table')
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
            Column::make('title'),
            Column::make('slug'),
            Column::make('link'),
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
        return 'PageBuilder_' . date('YmdHis');
    }
}
