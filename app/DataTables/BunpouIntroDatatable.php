<?php

namespace App\DataTables;

use App\Models\Bunpou;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
// use DB;

class BunpouIntroDatatable extends DataTable
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
                $__route_name_delete = 'bunpou.intro.destroy';
                $delete_url = route($__route_name_delete, $intro->id);

                $__route_name = 'bunpou.intro.edit';
                $edit_url = route($__route_name, $intro->id);

                return view('partials.action-button')->with(
                    compact('delete_url','__route_name_delete', '__route_name','edit_url',)
                );
            })
            ->editColumn('rownum', function ($intro) use ($start) {
                return $intro->rownum+$start;
            })
            ->editColumn('room', function ($intro) {
                $link_url = route("room.show",$intro->room);
                $link_text = $intro->title;

                return view('partials.action-button')->with(
                    compact('link_url','link_text',)
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Bunpou $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Bunpou $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        $query = $model->newQuery()
            ->join("master_rooms as room","room.id","=","bunpou.room")
            ->select([
                'bunpou.id',
                'bunpou.room',
                'bunpou.page',
                'room.title',
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
            Column::make('room')
                ->name('room')
                ->title('Room'),
            Column::make('page')
                ->name('page')
                ->title('Page')
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
