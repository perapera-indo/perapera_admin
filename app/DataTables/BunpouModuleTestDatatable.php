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
            ->addColumn('action', function($module){
                $__route_name = 'bunpou.module.edit';
                $__route_name_delete = 'bunpou.module.destroy';
                $edit_url = route($__route_name, $module->id);
                $delete_url = route($__route_name_delete, $module->id);
                $manage_test_url = route("bunpou.module.test.index");

                $deactivate_record = ($module->is_active==true)? route("bunpou.module.update",$module->id) : "";
                $deactivate_record_data = $module->id;

                $activate_record = ($module->is_active==true)? "" : route("bunpou.module.update",$module->id);
                $activate_record_data = $module->id;

                return view('partials.action-button')->with(
                    compact('edit_url','delete_url','__route_name','__route_name_delete', 'manage_test_url',
                        'activate_record_data','activate_record',
                        'deactivate_record_data','deactivate_record')
                );
            })
            ->editColumn('rownum', function ($module) use ($start) {
                return $module->rownum+$start;
            })
            ->editColumn('is_active', function ($module) {
                return view('backend.bunpou.module.active')->with(
                    compact('module')
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
            Column::make('order')
                ->name('order')
                ->title('Order')
                ->width("5%")
                ->addClass('text-center'),
            Column::make('is_active')
                ->name('is_active')
                ->title('Status')
                ->addClass('text-center')
                ->width("15%"),
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
