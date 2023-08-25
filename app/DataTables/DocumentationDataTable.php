<?php

namespace App\DataTables;

use App\Models\Dokumentasi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DocumentationDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($action) {
                $button = [
                    'edit' => [
                        'link' => route('admin.documentation.edit',  $action->id),
                        'permission' => 'documentation-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.documentation.destroy', $action->id),
                        'permission' => 'documentation-delete',
                    ]
                ];
                $button = json_decode(json_encode($button), FALSE);
                return view('admin.layouts.datatableButtons', compact('button'));
            })

            ->addColumn('created_at', function ($query) {
                return \Carbon\Carbon::parse($query->created_at)->format('M d - Y h:i a');
            })

            ->addColumn('updated_at', function ($query) {
                if ($query->updated_at == $query->created_at) {
                    return '-';
                } else {
                    return \Carbon\Carbon::parse($query->updated_at)->format('M d - Y h:i a');
                }
            })

            ->rawColumns(['created_at', 'updated_at', 'action']);
    }

    public function query(Dokumentasi $model)
    {
        $data = $model::orderBy('created_at', 'desc');
        return $data;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('statuskorban-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('reset')
            );
    }

    protected function getColumns()
    {
        return [
            Column::make('title'),
            Column::make('tanggal'),
            Column::make('status'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }
}
