<?php

namespace App\DataTables;

use App\Models\KanjiChapter;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
// use DB;

class KanjiChapterDatatable extends DataTable
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
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d'); // human readable format
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('Y-m-d'); // human readable format
            })
            ->addColumn('action', function ($data) {
                $edit_url = route('kanji-chapters.edit', $data->id);

                return view('partials.action-button')->with(
                    compact('edit_url')
                );
            })
            ->addColumn('add detail', function ($data) {
                // $edit_url = route('pattern-lessons.edit', $data->id);
                $add_url = route('kanji-contents-index', $data->id);

                return view('partials.action-button')->with(
                    compact('add_url')
                );
            });;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(KanjiChapter $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        return $model->newQuery()
            // ->where('slug','!=','super-admin')
            ->select([
                'kanji_chapters.id',
                'kanji_chapters.code',
                'kanji_chapters.name',
                'kanji_chapters.created_at',
                'kanji_chapters.updated_at',
                'master_groups.name as group_name',
                DB::raw('row_number() over () AS rownum'),
            ])->join('master_groups', 'master_groups.id', '=', 'kanji_chapters.master_group_id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('letter-category-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"row"<"col-sm-6"l><"col-sm-6"f>> <"row"<"col-sm-12"tr>> <"row"<"col-sm-5"i><"col-sm-7"p>>')
            ->orderBy(1)
            ->responsive(true)
            ->processing(true)
            ->serverSide(true)
            ->autoWidth(false)
            ->stateSave(true)
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
                ->searchable(false),
            // Column::make('code'),
            Column::make('name'),
            Column::make('group_name')->name('master_groups.name')->title('Grup'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
            Column::computed('action')
                ->visible($hasAction)
                ->exportable(false)
                ->printable(true)
                ->width(100)
                ->addClass('text-center'),
            Column::computed('add detail')->title('Tambah Kontent')
                ->visible($hasAction)
                ->exportable(false)
                ->printable(true)
                ->width(200)
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
        return 'KanjiChapter_' . date('YmdHis');
    }
}
