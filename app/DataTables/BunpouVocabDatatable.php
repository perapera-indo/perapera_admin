<?php

namespace App\DataTables;

use App\Models\BunpouVocab;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
// use DB;

class BunpouVocabDatatable extends DataTable
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
            ->addColumn('action', function($vocab){
                $__route_name_delete = 'bunpou.vocabulary.destroy';
                $delete_url = route($__route_name_delete, $vocab->id);

                $__route_name = 'bunpou.vocabulary.edit';
                $edit_url = route($__route_name, $vocab->id);

                $deactivate_record = ($vocab->is_active==true)? route("bunpou.vocabulary.deactivate",$vocab->id) : "";

                $activate_record = ($vocab->is_active==true)? "" : route("bunpou.vocabulary.activate",$vocab->id);

                return view('partials.action-button')->with(
                    compact('delete_url','__route_name_delete', '__route_name','edit_url', 'activate_record', 'deactivate_record')
                );
            })
            ->editColumn('rownum', function ($vocab) use ($start) {
                return $vocab->rownum+$start;
            })
            ->editColumn('is_active', function ($data) {
                return view('partials.active')->with(
                    compact('data')
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\BunpouVocab $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BunpouVocab $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        $query = $model->newQuery()
            ->select([
                'id',
                'word_jpn',
                'word_romaji',
                'word_idn',
                'is_active',
                'chapter',
                'order',
                DB::raw('row_number() over () AS rownum'),
            ])
            ->where("chapter",$this->request->chapter);

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $id = 'bunpou-vocabulary-dt';
        $domScript = "data.module = $('#$id-module').val(); data.chapter = $('#$id-chapter').val();";
        $stateSaveScript = "function(settings, data){
            data.search.search = data.search.search
            data.module = data.module ? data.module : $('#$id-module').val()
            data.chapter = data.chapter ? data.chapter : $('#$id-chapter').val()
        }";

        return $this->builder()
                    ->setTableId($id)
                    ->columns($this->getColumns())
                    ->minifiedAjax("",$domScript)
                    ->dom('<"row"<"col-sm-3 section-module"><"col-sm-3 section-chapter"><"col-sm-3"><"col-sm-3"f>> <"row"<"col-sm-12"tr>> <"row"<"col-sm-4"l><"col-sm-3"i><"col-sm-5"p>>')
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
                ->width("5%")
                ->addClass('text-center'),
            Column::make('word_jpn')
                ->name('word_jpn')
                ->title('Kata Jepang')
                ->addClass('text-center'),
            Column::make('word_romaji')
                ->name('word_romaji')
                ->title('Kata Romaji')
                ->addClass('text-center'),
            Column::make('word_idn')
                ->name('word_idn')
                ->title('Kata Indonesia')
                ->addClass('text-center'),
            Column::make('order')
                ->name('order')
                ->title('Order')
                ->width("10%")
                ->addClass('text-center'),
            Column::make('is_active')
                ->name('is_active')
                ->title('Status')
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
