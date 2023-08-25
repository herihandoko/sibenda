<?php

namespace App\DataTables\DataBencana;

use App\Models\DataBencana\DataBencana;
use App\Models\LaporanKejadian;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DataKejadianDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($action) {
                $button = [
                    'edit' => [
                        'link' => route('admin.laporan-kejadian.edit',  $action->id),
                        'permission' => 'laporan-kejadian-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.laporan-kejadian.destroy', $action->id),
                        'permission' => 'data-bencana-delete',
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

    public function query(LaporanKejadian $model)
    {
        $data = $model::whereIn('status', ['diterima', 'terkirim', 'diverifikasi', 'ditangani', 'selesei']);
        return $data;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('laporan-kejadian-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                // Button::make('create'),
                Button::make('reset')
            );
    }

    protected function getColumns()
    {
        return [
            Column::make('nomor_laporan'),
            Column::make('status'),
            Column::make('jenis_bencana')->title('Jenis Bencana'),
            Column::make('tgl_kejadian'),
            Column::make('waktu_kejadian'),
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
        return 'LaporanKejadian_' . date('YmdHis');
    }
}
