<?php

namespace App\DataTables;

use App\Models\LetterCourse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
// use DB;

class LetterCourseDatatable extends DataTable
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
            ->addColumn('is_active', function ($data) {
                if ($data->is_active == 1) {
                    return 'Active';
                } else {
                    return 'Inactive';
                }
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d'); // human readable format
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('Y-m-d'); // human readable format
            })
            ->addColumn('action', function ($data) {
                $__route_name = 'letter-courses.edit';
                $edit_url = route($__route_name, $data->id);

                return view('partials.action-button')->with(
                    compact('edit_url','__route_name')
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LetterCourse $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        return $model->newQuery()
            // ->where('slug','!=','super-admin')
            ->select([
                'letter_courses.id',
                'letter_courses.code',
                'letter_courses.title',
                'letter_courses.test_time',
                'letter_courses.is_active',
                'letter_courses.created_at',
                'letter_courses.updated_at',
                'letter_categories.name',
                DB::raw('row_number() over () AS rownum'),
            ])->join('letter_categories', 'letter_categories.id', '=', 'letter_courses.letter_category_id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('letter-course-table')
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
            Column::make('title')->title('Judul'),
            Column::make('test_time')->title('Waktu Test'),
            Column::computed('name')->title('Tipe Huruf'),
            Column::computed('is_active')->title('Status'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
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
        return 'LetterCourse_' . date('YmdHis');
    }
}
