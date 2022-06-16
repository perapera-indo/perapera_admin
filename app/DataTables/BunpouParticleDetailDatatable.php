<?php

namespace App\DataTables;

use App\Models\BunpouParticleDetail;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
// use DB;

class BunpouParticleDetailDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $start = $this->request->start;

        return datatables()
            ->eloquent($query)
            ->addColumn('action', function($detail){
                $__route_name = 'bunpou.particle.detail.edit';
                $__route_name_delete = 'bunpou.particle.detail.destroy';
                $edit_url = route($__route_name, $detail->id);
                $delete_url = route($__route_name_delete, $detail->id);

                return view('partials.action-button')->with(
                    compact('edit_url','delete_url','__route_name','__route_name_delete')
                );
            })
            ->editColumn('rownum', function ($detail) use ($start) {
                return $detail->rownum+$start;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\BunpouParticleDetail $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BunpouParticleDetail $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        $query = $model->newQuery()
            ->select([
                'id',
                'sentence_romaji',
                'sentence_jpn',
                'sentence_img',
                'particle',
                'sentence_idn',
                'sentence_description',
                'formula',
                'order',
                'is_active',
                DB::raw('row_number() over () AS rownum'),
            ])
            ->where("particle",$this->request->particle);

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $id = 'bunpou-particle-detail-dt';
        $domScript = "data.module = $('#$id-module').val(); data.chapter = $('#$id-chapter').val(); data.particle = $('#$id-particle').val();";
        $stateSaveScript = "function(settings, data){
            data.search.search = data.search.search
            data.module = data.module ? data.module : $('#$id-module').val()
            data.chapter = data.chapter ? data.chapter : $('#$id-chapter').val()
            data.particle = data.particle ? data.particle : $('#$id-particle').val()
        }";

        return $this->builder()
                    ->setTableId($id)
                    ->columns($this->getColumns())
                    ->minifiedAjax("",$domScript)
                    ->dom('<"row"<"col-sm-2 section-module"><"col-sm-2 section-chapter"><"col-sm-2 section-particle"><"col-sm-3"><"col-sm-3"f>> <"row"<"col-sm-12"tr>> <"row"<"col-sm-4"l><"col-sm-3"i><"col-sm-5"p>>')
                    ->orderBy(0,'asc')
                    ->responsive(true)
                    ->processing(true)
                    ->serverSide(true)
                    ->autoWidth(false)
                    ->stateSave(true)
                    ->stateSaveParams($stateSaveScript)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $hasAction = isHasAnyActionColumn();
        return [
            Column::make('rownum')
                ->title('#')
                ->searchable(false)
                ->addClass('text-center')
                ->width("5%"),
            Column::make('sentence_idn')
                ->name('sentence_idn')
                ->title('Kalimat'),
            Column::make('order')
                ->name('order')
                ->title('Order')
                ->width("10%")
                ->addClass('text-center'),
            Column::computed('action')
                ->searchable(false)
                ->visible($hasAction)
                ->exportable(false)
                ->printable(true)
                ->width("20%")
                ->addClass('text-center')
        ];
    }
}
