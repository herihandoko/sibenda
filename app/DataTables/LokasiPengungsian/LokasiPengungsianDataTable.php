<?php

namespace App\DataTables\LokasiPengungsian;

use App\Models\LokasiPengungsian\LokasiPengungsian;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LokasiPengungsianDataTable extends DataTable {

    public function dataTable($query) {
        return datatables()
                        ->eloquent($query)
                        ->addColumn('action', function ($action) {
                            $button = [
                                'edit' => [
                                    'link' => route('admin.data.lokasi-pengungsian.edit', $action->id),
                                    'permission' => 'lokasi-pengungsian-edit',
                                ],
                                'delete' => [
                                    'link' => route('admin.data.lokasi-pengungsian.destroy', $action->id),
                                    'permission' => 'lokasi-pengungsian-delete',
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

    public function query(LokasiPengungsian $model) {
        $data = $model::join('m_jenis_hunian', 'data_lokasi_pengungsian.jenis_hunian_id', '=', 'm_jenis_hunian.id')
                ->join('indonesia_provinces', 'data_lokasi_pengungsian.provinsi', '=', 'indonesia_provinces.id')
                ->select(['data_lokasi_pengungsian.*', 'm_jenis_hunian.id as jenisHunianId', 'm_jenis_hunian.name', 'indonesia_provinces.name as nama_provinsi'])
                ->where('data_lokasi_pengungsian.is_deleted', 0);
        return $data;
    }

    public function html() {
        return $this->builder()
                        ->setTableId('lokasipengungsian-table')
                        ->columns($this->getColumns())
                        ->minifiedAjax()
                        ->dom('Bfrtip')
                        ->orderBy(1)
                        ->buttons(
                                Button::make('create'),
                                Button::make('reset'),
        );
    }

    protected function getColumns() {
        return [
            Column::make('kode'),
            Column::make('name')->title('Jenis Hunian'),
            Column::make('kapasitas'),
            Column::make('nama_provinsi'),
            Column::make('created_at'),
            Column::make('updated_at'),
                    Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(100)
                    ->addClass('text-center'),
        ];
    }

    protected function filename() {
        return 'LokasiPengungsian_' . date('YmdHis');
    }

}
