<?php

namespace App\DataTables;

use App\Models\ActivityLog;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ActivityLogDataTable extends DataTable
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
            ->addColumn('waktu', fn ($activityLog) => $activityLog->created_at->format('d-m-Y, H:i'));
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ActivityLog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ActivityLog $model)
    {
        $user = auth()->user();
        $logs = $model->newQuery()->with('user');
        $logs->when($user->hasRole('rt'), function ($logs) use ($user) {
            return $logs->whereHas('user', function ($q) use ($user) {
                $q->where('rt_id', $user->rt_id);
                $q->whereHas('roles', function ($q) {
                    $q->where('name', '!=', ['admin', 'rw']);
                });
            });
        });

        return $logs;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('activitylog-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
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
            Column::make('id')->hidden(),
            Column::make('user.name')->title('Nama'),
            Column::make('user.role')->title('Role')->searchable(false)->orderable(false),
            Column::make('action')->title('Aksi'),
            Column::computed('waktu'),
            Column::make('current_url'),
            Column::make('previous_url'),
            Column::make('file')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ActivityLog_' . date('YmdHis');
    }
}
