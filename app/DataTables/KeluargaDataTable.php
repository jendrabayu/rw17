<?php

namespace App\DataTables;

use App\Models\Keluarga;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KeluargaDataTable extends DataTable
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
            ->addColumn('action', 'keluarga.action')
            ->addColumn('kepala_keluarga', function ($keluarga) {
                $kepala_keluarga = $keluarga
                    ->penduduk->where('statusHubunganDalamKeluarga.nama', 'KEPALA KELUARGA')
                    ->first();
                return $kepala_keluarga ? $kepala_keluarga->nama : '';
            })
            ->addColumn('jumlah_orang', function ($keluarga) {
                return $keluarga->penduduk->count();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Keluarga $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Keluarga $keluarga)
    {
        $user = auth()->user();
        $keluarga = $keluarga->newQuery()->with('penduduk.statusHubunganDalamKeluarga');

        if ($user->hasRole('rt')) {
            $keluarga->whereRtId($user->rt_id);
        }

        if ($user->hasRole(['admin', 'rw'])) {
            $keluarga->when(request()->has('rt'), function ($q) {
                return $q->whereRtId(request()->get('rt'));
            });
        }

        return $keluarga;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('tabelKeluarga')
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
            Column::make('nomor')->title('No. Kartu Keluarga'),
            Column::computed('kepala_keluarga'),
            Column::computed('jumlah_orang'),
            Column::make('alamat'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Keluarga_' . date('YmdHis');
    }
}
