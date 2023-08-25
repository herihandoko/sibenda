<?php

namespace App\DataTables\DataKorban;

use App\Models\DataKorban\DataKorban;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;

class DataKorbanDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($action) {
                $button = [
                    'edit' => [
                        'link' => route('admin.data.data-korban.edit',  $action->id),
                        'permission' => 'data-korban-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.data.data-korban.destroy', $action->id),
                        'permission' => 'data-korban-delete',
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

    public function query(DataKorban $model)
    {
        $data = $model::select('*', DB::raw('(CASE WHEN jns_kelamin = 1 THEN "Laki-Laki" ELSE "Perempuan" END) AS jns_kelamin'))->where('is_deleted', 0);
        return $data;
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('datakorban-table')
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
            Column::make('nama_korban'),
            Column::make('nik'),
            Column::make('jns_kelamin'),
            Column::make('tgl_lahir'),
            Column::make('usia'),
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
        return 'DataKorban_' . date('YmdHis');
    }
}