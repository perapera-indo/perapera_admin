<?php

namespace App\DataTables;

use App\Models\Bank;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
// use DB;

class SettingDatatable extends DataTable
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
//            ->editColumn('logo', function ($setting) {
//                $url = url('/images/no-image.png');
//                if($setting->logo != ''){
//                    $url = get_file($setting->logo);
//                }
//                return '<img src='.$url.' border="0" width="100px" class="datatable-img" align="center" />';
//            })
//            ->editColumn('favicon', function ($setting) {
//                $url = url('/images/no-image.png');
//                if($setting->favicon != ''){
//                    $url = get_file($setting->favicon);
//                }
//                return '<img src='.$url.' border="0" width="100px" class="img-rounded" align="center" />';
//            })
            ->editColumn('allow_public_register', function ($setting) {
                $allowPublicRegister = $setting->allow_public_register == false ? 'No' : 'Yes';
                return $allowPublicRegister;
            })
            ->editColumn('allow_full_sidebar', function ($setting) {
                $allowfullSidebar = $setting->allow_full_sidebar == false ? 'No' : 'Yes';
                return $allowfullSidebar;
            })
            ->addColumn('action', function($setting){
                $edit_url = route('settings.edit', $setting->id);

                return view('partials.action-button')->with(
                    compact('edit_url')
                );
            })->rawColumns(['logo','favicon','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Bank $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Setting $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        $query = $model->newQuery()
            ->select([
                'settings.id',
                'settings.application_name',
                'settings.logo',
                'settings.favicon',
                'settings.allow_public_register',
                'settings.allow_full_sidebar',
                'settings.created_at',
                'settings.updated_at',
                DB::raw('row_number() over() AS rownum'),
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
                    ->setTableId('settings-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"row"<"col-sm-6"l>> <"row"<"col-sm-12"tr>> <"row"<"col-sm-7"p>>')
                    ->orderBy(1)
                    ->responsive(true)
                    ->processing(true)
                    ->serverSide(true)
                    ->autoWidth(false)
                    ->paging(false)
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
            Column::make('application_name'),
//            Column::make('logo'),
//            Column::make('favicon'),
            Column::make('allow_public_register'),
            Column::make('allow_full_sidebar'),
            Column::computed('action')
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
        return 'Setting_' . date('YmdHis');
    }
}
