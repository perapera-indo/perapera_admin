<?php

namespace App\DataTables;

use App\Models\SuujiModules;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
// use DB;

class SuujiModulesDatatable extends DataTable
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
                $__route_name_delete = 'suuji.module.destroy';
                $delete_url = route($__route_name_delete, $module->id);

                $__route_name = 'suuji.module.edit';
                $edit_url = route($__route_name, $module->id);

                $deactivate_record = ($module->is_active==true)? route("suuji.module.deactivate",$module->id) : "";

                $activate_record = ($module->is_active==true)? "" : route("suuji.module.activate",$module->id);

                return view('partials.action-button')->with(
                    compact('delete_url','__route_name_delete', '__route_name','edit_url', 'activate_record', 'deactivate_record')
                );
            })
            ->editColumn('rownum', function ($module) use ($start) {
                return $module->rownum+$start;
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
     * @param \App\SuujiModules $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SuujiModules $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        $query = $model->newQuery()
            ->select([
                'id',
                'name',
                'is_active',
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
                    ->setTableId('suuji-modules-dt')
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
                ->width("5%")
                ->addClass('text-center'),
            Column::make('name')
                ->name('name')
                ->title('Name')
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
