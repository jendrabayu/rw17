<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('role', function ($user) {
                return strtoupper($user->role);
            })
            ->addColumn('rt', function ($user) {
                return ltrim($user->rt->nomor, '0');
            })
            ->addColumn('action', 'users.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $user)
    {
        return $user->newQuery()->with('rt');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('tabelPengguna')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->language('https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                ->title('#')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('id')->hidden(),
            Column::make('name')->title('Nama'),
            Column::make('username'),
            Column::make('email'),
            Column::make('no_hp')->title('No. Hp/WhatsApp')->orderable(false),
            Column::computed('role')->orderable(false)->searchable(false),
            Column::computed('rt')->title('RT')->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
