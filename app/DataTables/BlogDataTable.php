<?php

namespace App\DataTables;

use App\Models\Blog;
use Functions;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlogDataTable extends DataTable
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
            ->addColumn('status', function ($status) {
                if ($status->status == 1) {
                    return '<div class="btn btn-success btn-sm"> Published </div>';
                } else return '<div class="btn btn-secondary btn-sm"> Draft </div>';
            })
            ->addColumn('comment_status', function ($status) {
                if ($status->comment_status == 1) {
                    return '<div class="btn btn-primary btn-sm"> Enabled </div>';
                } else return '<div class="btn btn-danger btn-sm"> Disabled </div>';
            })
            ->addColumn('on_featured', function ($status) {
                if ($status->on_featured == 1) {
                    return '<div class="btn btn-primary btn-sm"> Enabled </div>';
                } else return '<div class="btn btn-danger btn-sm"> Disabled </div>';
            })
            ->addColumn('created_at', function ($query) {
                return \Carbon\Carbon::parse($query->created_at)->format('M d - Y h:i a');
            })
            ->addColumn('action', function ($action) {
                $button = [
                    'edit' => [
                        'link' => route('admin.blog.edit',  $action->id),
                        'permission' => 'blog-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.blog.destroy', $action->id),
                        'permission' => 'blog-delete',
                    ]
                ];
                $button = json_decode(json_encode($button), FALSE);
                return view('admin.layouts.datatableButtons', compact('button'));
            })
            ->rawColumns(['image', 'created_at', 'action', 'status', 'comment_status', 'on_featured']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Blog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Blog $model)
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
            ->setTableId('blog-table')
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
            Column::make('image'),
            Column::make('title')->width(100),
            Column::make('status'),
            Column::make('comment_status'),
            Column::make('on_featured'),
            Column::make('created_at'),
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
        return 'Blog_' . date('YmdHis');
    }
}
