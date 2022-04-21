<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
// use DB;

class UserDatatable extends DataTable
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
            ->addColumn('action', function($user){
                $__route_name = 'user.edit';
                $__route_name_delete = 'user.destroy';
                $edit_url = route($__route_name, $user->id);
                $delete_url = route($__route_name_delete, $user->id);

                return view('partials.action-button')->with(
                    compact('edit_url','delete_url','__route_name','__route_name_delete')
                );
            })
            ->editColumn('rownum', function ($user) use ($start) {
                return $user->rownum+$start;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $onlyOwned = isOnlyDataOwned();

        // DB::statement(DB::raw('set @rownum=0'));
        $query = $model->newQuery()
            ->leftJoin('role_users', 'role_users.user_id','=', 'users.id')
            ->leftJoin('roles','roles.id','=','role_users.role_id')
            ->select([
                'users.id',
                'users.email',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.created_at',
                'users.updated_at',
                'roles.name as roles_name',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS full_name"),
                DB::raw('row_number() over () AS rownum'),
            ]);

        if($onlyOwned){
            $query = $query->where('users.created_by','=',user_info('id'));
        }

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
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"row"<"col-sm-6"l><"col-sm-6"f>> <"row"<"col-sm-12"tr>> <"row"<"col-sm-5"i><"col-sm-7"p>>')
                    ->orderBy(1,'asc')
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
            Column::make('full_name')
                ->searchable(false),
            Column::make('roles_name')
                ->name('roles.name')
                ->title('Role Name'),
            Column::make('email')
                ->searchable(false),
            Column::make('first_name')
                ->visible(false),
            Column::make('last_name')
                ->visible(false),
            Column::make('created_at'),
            Column::make('updated_at'),
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
        return 'User_' . date('YmdHis');
    }
}
