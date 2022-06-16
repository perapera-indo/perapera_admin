<?php

namespace App\DataTables;

use App\Models\BunpouModuleTest;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
// use DB;

class BunpouModuleTestDatatable extends DataTable
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
            ->addColumn('action', function($test){
                $__route_name = 'bunpou.module.test.edit';
                $__route_name_delete = 'bunpou.module.test.destroy';
                $edit_url = route($__route_name, $test->id);
                $delete_url = route($__route_name_delete, $test->id);

                $deactivate_record = ($test->is_active==true)? route("bunpou.module.test.deactivate",$test->id) : "";

                $activate_record = ($test->is_active==true)? "" : route("bunpou.module.test.activate",$test->id);

                return view('partials.action-button')->with(
                    compact('edit_url','delete_url','__route_name','__route_name_delete', 'activate_record', 'deactivate_record')
                );
            })
            ->editColumn('rownum', function ($test) use ($start) {
                return $test->rownum+$start;
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
     * @param \App\BunpouModuleTest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BunpouModuleTest $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        $query = $model->newQuery()
            ->select([
                'id',
                'title',
                'module',
                'time',
                'question_count',
                'order',
                'is_active',
                DB::raw('row_number() over () AS rownum'),
            ])
            ->where("module",$this->request->module);

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $id = 'bunpou-module-test-dt';
        $domScript = "data.module = $('#$id-module').val();";
        $stateSaveScript = "function(settings, data){
            data.search.search = data.search.search
            data.module = data.module ? data.module : $('#$id-module').val()
        }";

        return $this->builder()
                    ->setTableId($id)
                    ->columns($this->getColumns())
                    ->minifiedAjax("",$domScript)
                    ->dom('<"row"<"col-sm-3 section-module"><"col-sm-6"><"col-sm-3"f>> <"row"<"col-sm-12"tr>> <"row"<"col-sm-4"l><"col-sm-3"i><"col-sm-5"p>>')
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
            Column::make('title')
                ->name('title')
                ->title('Title'),
            Column::make('time')
                ->name('time')
                ->title('Time')
                ->width("10%")
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
                ->width("20%")
                ->addClass('text-center')
        ];
    }
}
