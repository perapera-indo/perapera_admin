<?php

namespace App\DataTables;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
// use DB;

class MemberDatatable extends DataTable
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
            // ->addColumn('action', function($user){
            //     $edit_url = route('user.edit', $user->id);
            //     $delete_url = route('user.destroy', $user->id);

            //     return view('partials.action-button')->with(
            //         compact('edit_url','delete_url')
            //     );
            // })
            ->editColumn('rownum', function ($user) use ($start) {
                return $user->rownum + $start;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Member $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Member $model)
    {

        // DB::statement(DB::raw('set @rownum=0'));
        $query = $model->newQuery()
            ->select([
                'members.id',
                'members.username',
                'members.email',
                'members.full_name',
                'members.email',
                'members.phone',
                'members.is_verified',
                'members.is_socmed',
                // 'members.gender',
                'members.created_at',
                'members.updated_at',
                DB::raw("CASE members.gender WHEN 'M' THEN 'Male' ELSE 'Female' END AS gender"),
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
            ->setTableId('member-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"row"<"col-sm-6"l><"col-sm-6"f>> <"row"<"col-sm-12"tr>> <"row"<"col-sm-5"i><"col-sm-7"p>>')
            ->orderBy(1, 'asc')
            ->responsive(true)
            ->processing(true)
            ->serverSide(true)
            ->autoWidth(false)
            //                    ->stateSave(true)
            ->lengthMenu([20, 40, 60, 80, 100])
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
        // $hasAction = isHasAnyActionColumn();
        return [
            Column::make('rownum')
                ->title('#')
                ->searchable(false),
            Column::make('username')
                ->visible(false),
            Column::make('full_name')
                ->searchable(false),
            Column::make('email')
                ->searchable(false),
            Column::make('phone')
                ->visible(true),
            Column::make('gender')
                ->visible(true)
                ->searchable(false),
            Column::make('is_verified')
                ->visible(true),
            Column::make('is_socmed')
                ->visible(true),
            // Column::make('created_at'),
            // Column::make('updated_at'),
            // Column::computed('action')
            //     ->visible($hasAction)
            //     ->exportable(false)
            //     ->printable(true)
            //     ->width(100)
            //     ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Member_' . date('YmdHis');
    }
}
