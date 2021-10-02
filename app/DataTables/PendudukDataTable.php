<?php

namespace App\DataTables;

use App\Models\Penduduk;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PendudukDataTable extends DataTable
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
            ->addColumn('tanggal_lahir', fn ($penduduk) => $penduduk->tanggal_lahir->format('d-m-Y'))
            ->addColumn('action', 'penduduk.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Penduduk $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Penduduk $penduduk)
    {
        $user = auth()->user();
        $penduduk = $penduduk->newQuery()->filter();

        if ($user->hasRole('rt')) {
            $penduduk = $penduduk->whereHas('keluarga', function ($q) use ($user) {
                $q->whereRtId($user->rt_id);
            });
        }

        if ($user->hasRole(['admin', 'rw'])) {
            $penduduk = $penduduk->whereHas('keluarga.rt', function ($q) use ($user) {
                $q->whereRwId($user->rt->rw_id);
            })
                ->when(request()->has('rt'), function ($q) {
                    $q->whereHas('keluarga.rt', function ($q) {
                        $q->where('id', request()->get('rt'));
                    });
                });
        }

        return $penduduk;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('tabelPenduduk')
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
            Column::make('keluarga.nomor')->title('No. Kartu Keluarga'),
            Column::make('nik')->title('NIK'),
            Column::make('nama'),
            Column::make('jenis_kelamin_text')->title('Jenis Kelamin')->orderable(false)->searchable(false),
            Column::make('tempat_lahir'),
            Column::computed('tanggal_lahir'),
            Column::make('usia')->searchable(false)->orderable(false),
            Column::make('agama.nama'),
            Column::make('pekerjaan.nama'),
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
        return 'Penduduk_' . date('YmdHis');
    }
}
