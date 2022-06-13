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
            ->addColumn('action', function($intro){
                $__route_name_delete = 'bunpou.vocabulary.destroy';
                $delete_url = route($__route_name_delete, $intro->id);

                $__route_name = 'bunpou.vocabulary.edit';
                $edit_url = route($__route_name, $intro->id);

                return view('partials.action-button')->with(
                    compact('delete_url','__route_name_delete', '__route_name','edit_url',)
                );
            })
            ->editColumn('rownum', function ($intro) use ($start) {
                return $intro->rownum+$start;
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
            ]);

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('room-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"row"<"col-sm-6"l><"col-sm-6"f>> <"row"<"col-sm-12"tr>> <"row"<"col-sm-5"i><"col-sm-7"p>>')
                    ->orderBy(0,'asc')
                    ->responsive(true)
                    ->processing(true)
                    ->serverSide(true)
                    ->autoWidth(false)
//                    ->stateSave(true)
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
            Column::computed('action')
                ->searchable(false)
                ->visible($hasAction)
                ->exportable(false)
                ->printable(true)
                ->width("15%")
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
