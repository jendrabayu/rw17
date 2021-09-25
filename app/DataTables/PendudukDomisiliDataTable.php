<?php

namespace App\DataTables;

use App\Models\PendudukDomisili;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PendudukDomisiliDataTable extends DataTable
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
            ->addColumn('tanggal_lahir', function ($penduduk) {
                return $penduduk->tanggal_lahir->format('d-m-Y');
            })
            ->addColumn('action', 'penduduk-domisili.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PendudukDomisili $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PendudukDomisili $pendudukDomisili)
    {
        $user = auth()->user();

        $pendudukDomisili = $pendudukDomisili->newQuery()->with([
            'pekerjaan',
            'agama',
            'statusPerkawinan'
        ]);

        if ($user->hasRole('rt')) {
            $pendudukDomisili->whereRtId($user->rt_id)->get();
        }

        if ($user->hasRole('rw')) {
            $pendudukDomisili->when(request()->has('rt'), function ($q) {
                return $q->whereRtId(request()->get('rt'));
            });
        }

        return $pendudukDomisili;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('tabelPendudukDomisili')
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
            Column::make('jenis_kelamin_text')->title('Jenis Kelamin')->orderable(false)->searchable(false),
            Column::make('tempat_lahir'),
            Column::computed('tanggal_lahir'),
            Column::make('usia')->orderable(false)->searchable(false),
            Column::make('agama.nama')->title('Agama'),
            Column::make('pekerjaan.nama')->title('Pekerjaan'),
            Column::make('status_perkawinan.nama', 'statusPerkawinan.nama')->title('Status Perkawinan'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'PendudukDomisili_' . date('YmdHis');
    }
}
