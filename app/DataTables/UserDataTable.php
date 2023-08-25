<?php

namespace App\DataTables;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->addColumn('action', function ($query) {
                $button = [
                    'edit' => [
                        'link' => route('admin.users.edit',  $query->id),
                        'permission' => 'user-edit',
                    ],
                    'delete' => [
                        'link' => route('admin.users.destroy', $query->id),
                        'permission' => 'user-delete',
                    ]
                ];

                if (Auth::user()->id == $query->id) {
                    unset($button['delete']);
                }

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

            ->addColumn('role', function ($query) {
                $user = Admin::find($query->id);
                $userRole = $user->roles->pluck('name', 'name')->all();

                $badge = '';
                foreach ($userRole as $key => $value) {
                    $badge .= '<span class="badge badge-primary">' . $value . '</span>';
                }

                return $badge;
            })
            
            ->rawColumns(['role', 'created_at', 'updated_at', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Admin $model)
    {
        $data = $model::where('is_deleted', 0)->orderBy('created_at', 'desc');
        return $data;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('user-table')
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
            Column::make('name')->addClass('text-left'),
            Column::make('username')->addClass('text-center'),
            Column::make('email')->addClass('text-left'),
            Column::make('role')->addClass('text-center')->orderable(true),
            Column::make('created_at')->title('Created Date')->addClass('text-center')->orderable(true),
            Column::make('updated_at')->title('Updated Date')->addClass('text-center')->orderable(true),
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
        return 'User_' . date('YmdHis');
    }
}
