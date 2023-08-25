<?php

namespace App\DataTables;

use App\Models\Appointment;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AppointmentDataTable extends DataTable
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
            ->addColumn('status', function ($status) {
                if ($status->status == 1) {
                    return '<div class="btn btn-primary btn-sm"> Accepted </div>';
                }
                if ($status->status == 2) {
                    return '<div class="btn btn-success btn-sm"> Completed </div>';
                }
                if ($status->status == 3) {
                    return '<div class="btn btn-danger btn-sm"> Cancelled </div>';
                } else return '<div class="btn btn-danger btn-sm"> Pending </div>';
            })
            ->addColumn('action', function ($action) {

                $button = [
                    'edit' => [
                        'link' => route('admin.appointment.edit',  $action->id),
                        'permission' => 'appointment-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.appointment.destroy', $action->id),
                        'permission' => 'appointment-delete',
                    ]
                ];
                $button = json_decode(json_encode($button), FALSE);
                return view('admin.layouts.datatableButtons', compact('button'));

            })
            ->addColumn('appointment_date', function ($query) {
                return \Carbon\Carbon::parse($query->created_at)->format('M d - Y h:i a');
            })
            ->rawColumns(['action', 'status', 'appointment_date']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Appointment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Appointment $model)
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
            ->setTableId('appointment-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(


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

            Column::make('id'),
            Column::make('name')->width(150),
            Column::make('email')->width(150),

            Column::make('message')->width(250),
            Column::make('appointment_date')->width(150),
            Column::make('status')->width(100),

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
        return 'Appointment_' . date('YmdHis');
    }
}
