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
            ->addColumn('no_kartu_keluarga', function ($rumah) {
                return $rumah->keluarga->map(function ($keluarga) {
                    return "<a href=\"route('keluarga.show', $keluarga->id)\">$keluarga->nomor</a>";
                })->join('');
            })
            ->addColumn('action', 'rumah.action')
            ->rawColumns(['action', 'no_kartu_keluarga']);
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
        $rumah = $rumah->newQuery()->with('keluarga');

        if ($user->hasRole('rt')) {
            $rumah->whereRtId($user->rt_id);
        }

        if ($user->hasRole('rw')) {
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
            Column::make('alamat'),
            Column::make('nomor')->title('No. Rumah'),
            Column::computed('no_kartu_keluarga')->title('No. Kartu Keluarga'),
            Column::make('tipe_bangunan'),
            Column::make('penggunaan_bangunan'),
            Column::make('kontruksi_bangunan'),
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
