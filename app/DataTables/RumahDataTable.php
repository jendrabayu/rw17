<?php

namespace App\DataTables;

use App\Models\Rumah;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RumahDataTable extends DataTable
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
            ->addColumn('keluarga', function ($rumah) {
                return $rumah->keluarga->map(fn ($item) => "<a href=\"route('keluarga.show', $item->id)\">$item->nomor</a><br>")->join('');
            })
            ->addColumn('warga_domisili', function ($rumah) {
                return $rumah->pendudukDomisili->map(fn ($item) => "<a href=\"route('penduduk-domisili.show', $item->id)\">$item->nik</a><br>")->join('');
            })
            ->addColumn('action', 'rumah.action')
            ->rawColumns(['action', 'keluarga', 'warga_domisili']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Rumah $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Rumah $rumah)
    {
        $user = auth()->user();
        $rumah = $rumah->newQuery()->with(['keluarga', 'pendudukDomisili', 'penggunaanBangunan']);

        if ($user->hasRole('rt')) {
            $rumah->whereRtId($user->rt_id);
        }

        if ($user->hasRole(['admin', 'rw'])) {
            $rumah->when(request()->has('rt'), function ($q) {
                $q->whereRtId(request()->rt);
            });
        }

        return $rumah;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('tabelRumah')
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
            Column::make('nomor')->title('No. Rumah'),
            Column::make('alamat'),
            Column::computed('keluarga'),
            Column::computed('warga_domisili'),
            Column::make('penggunaan_bangunan.nama', 'penggunaanBangunan.nama')->title('Penggunaan Bangunan'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Rumah_' . date('YmdHis');
    }
}
