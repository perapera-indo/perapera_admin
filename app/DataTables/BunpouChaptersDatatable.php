<?php

namespace App\DataTables;

use App\Models\BunpouChapters;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
// use DB;

class BunpouChaptersDatatable extends DataTable
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
            ->addColumn('action', function($chapter){
                $__route_name = 'bunpou.chapter.edit';
                $__route_name_delete = 'bunpou.chapter.destroy';
                $edit_url = route($__route_name, $chapter->id);
                $delete_url = route($__route_name_delete, $chapter->id);

                $deactivate_record = ($chapter->is_active==true)? route("bunpou.chapter.deactivate",$chapter->id) : "";

                $activate_record = ($chapter->is_active==true)? "" : route("bunpou.chapter.activate",$chapter->id);

                return view('partials.action-button')->with(
                    compact('edit_url','delete_url','__route_name','__route_name_delete', 'activate_record', 'deactivate_record')
                );
            })
            ->editColumn('rownum', function ($chapter) use ($start) {
                return $chapter->rownum+$start;
            })
            ->editColumn('is_active', function ($chapter) {
                return view('backend.bunpou.chapter.active')->with(
                    compact('chapter')
                );
            })
            ->editColumn('moduleName', function ($chapter) {
                $link_url = route("bunpou.module.show",$chapter->module);
                $link_text = $chapter->moduleName;

                return view('partials.action-button')->with(
                    compact('link_url','link_text',)
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\BunpouChapters $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BunpouChapters $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        $query = $model->newQuery()
            ->join("bunpou_modules","bunpou_modules.id","=","bunpou_chapters.module")
            ->select([
                'bunpou_chapters.id',
                'bunpou_chapters.name',
                'bunpou_chapters.order',
                'bunpou_chapters.module',
                'bunpou_chapters.is_active',
                'bunpou_modules.name as moduleName',
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
                    // ->stateSave(true)
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
            Column::make('name')
                ->name('name')
                ->title('Name'),
            Column::make('moduleName')
                ->name('bunpou_modules.name')
                ->title('Module'),
            Column::make('order')
                ->name('order')
                ->title('Order')
                ->width("5%")
                ->addClass('text-center'),
            Column::make('is_active')
                ->name('is_active')
                ->title('Status')
                ->addClass('text-center')
                ->width("10%"),
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
