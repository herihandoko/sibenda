<?php

namespace App\DataTables\Master;

use App\Models\Master\JalurKomunikasi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JalurKomunikasiDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($action) {
                $button = [
                    'edit' => [
                        'link' => route('admin.master.jalur-komunikasi.edit',  $action->id),
                        'permission' => 'jalur-komunikasi-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.master.jalur-komunikasi.destroy', $action->id),
                        'permission' => 'jalur-komunikasi-delete',
                    ]
                ];
                $button = json_decode(json_encode($button), FALSE);
                return view('admin.layouts.datatableButtons', compact('button'));
            })
            
            ->addColumn('created_at', function ($query) {
                return \Carbon\Carbon::parse($query->created_at)->format('M d - Y h:i a');
            })
            
             ->addColumn('updated_at', function ($query) {
                if($query->updated_at == $query->created_at) {
                    return '-';
                } else {
                    return \Carbon\Carbon::parse($query->updated_at)->format('M d - Y h:i a');   
                }
            })
            
            ->rawColumns(['created_at', 'updated_at', 'action']);
    }

    public function query(JalurKomunikasi $model)
    {
        $data = $model::where('is_deleted', 0);
        return $data;
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('jalurkomunikasi-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('reset'),
                    );
    }

    protected function getColumns()
    {
        return [
            Column::make('name'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(100)
            ->addClass('text-center'),
        ];
    }

    protected function filename()
    {
        return 'JalurKomunikasi_' . date('YmdHis');
    }
}