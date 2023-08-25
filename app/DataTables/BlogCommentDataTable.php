<?php

namespace App\DataTables;

use App\Models\BlogComment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlogCommentDataTable extends DataTable
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
                        'link' => route('admin.blog-comment.edit',  $action->id),
                        'permission' => 'blog-comment-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.blog-comment.destroy', $action->id),
                        'permission' => 'blog-comment-delete',
                    ]
                ];
                $button = json_decode(json_encode($button), FALSE);
                return view('admin.layouts.datatableButtons', compact('button'));
            })

            ->addColumn('status', function ($status) {
                if ($status->status == 1) {
                    return '<div class="btn btn-success btn-sm"> Active </div>';
                } else return '<div class="btn btn-secondary btn-sm"> Deactivated </div>';
            })
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BlogComment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BlogComment $model)
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
            ->setTableId('blogcomment-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
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
            Column::make('name')->width(150),
            Column::make('email'),
            Column::make('comment'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'BlogComment_' . date('YmdHis');
    }
}
