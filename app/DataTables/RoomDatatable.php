<?php

namespace App\DataTables;

use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
// use DB;

class RoomDatatable extends DataTable
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
            ->addColumn('action', function($room){
                $__route_name = 'room.edit';
                $__route_name_delete = 'room.destroy';
                $edit_url = route($__route_name, $room->id);
                $delete_url = route($__route_name_delete, $room->id);

                return view('partials.action-button')->with(
                    compact('edit_url','delete_url','__route_name','__route_name_delete')
                );
            })
            ->editColumn('rownum', function ($room) use ($start) {
                return $room->rownum+$start;
            })
            ->editColumn('path', function ($room) {
                $download_url = asset($room->path);
                $download_blank = true;
                return view('partials.action-button')->with(
                    compact('download_url','download_blank')
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Room $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Room $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        $query = $model->newQuery()
            ->select([
                'id',
                'title',
                'path',
                'desc',
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
                ->searchable(false),
            Column::make('title')
                ->name('title')
                ->title('Title'),
            Column::make('desc')
                ->name('desc')
                ->title('Description'),
            Column::make('path')
                ->name('path')
                ->title('Image / Video')
                ->searchable(false),
            Column::computed('action')
                ->searchable(false)
                ->visible($hasAction)
                ->exportable(false)
                ->printable(true)
                ->width(100)
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
