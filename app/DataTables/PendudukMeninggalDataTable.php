<?php

namespace App\DataTables;

use App\Models\PendudukMeninggal;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PendudukMeninggalDataTable extends DataTable
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
            ->addColumn('tanggal_kematian', fn ($pendudukMeninggal) => $pendudukMeninggal->tanggal_kematian->format('d-m-Y'))
            ->addColumn('jam_kematian', fn ($pendudukMeninggal) => $pendudukMeninggal->jam_kematian->format('H:i'))
            ->addColumn('action', 'penduduk-meninggal.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PendudukMeninggal $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PendudukMeninggal $pendudukMeninggal)
    {
        $user = auth()->user();
        $pendudukMeninggal = $pendudukMeninggal->newQuery();

        if ($user->hasRole('rt')) {
            $pendudukMeninggal->where('rt_id', $user->rt->id);
        }

        if ($user->hasRole('rw')) {
            $pendudukMeninggal->when(request()->has('rt'), function ($q) {
                return $q->where('rt_id', request()->get('rt'));
            });
        }

        return $pendudukMeninggal;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('tabelPendudukMeninggal')
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
            Column::make('nik')->title('NIK'),
            Column::make('nama'),
            Column::computed('tanggal_kematian'),
            Column::computed('jam_kematian'),
            Column::make('tempat_kematian'),
            Column::make('sebab_kematian'),
            Column::make('tempat_pemakaman'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'PendudukMeninggal_' . date('YmdHis');
    }
}
