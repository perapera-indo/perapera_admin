<?php

namespace App\DataTables;

use App\Models\PatternLessonDetail;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
// use DB;

class PatternLessonDetailDatatable extends DataTable
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
                return $data->created_at == "" ? "" : $data->created_at->format('Y-m-d'); // human readable format
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at == "" ? "" : $data->updated_at->format('Y-m-d'); // human readable format
            })
            ->addColumn('action', function ($data) {
                $edit_url = route('lesson-detail-edit', [$data->pattern_lesson_id, $data->id]);
                // $add_url = route('lesson-detail-add', $data->id);

                return view('partials.action-button')->with(
                    compact('edit_url')
                );
            })
            ->addColumn('example', function ($data) {
                $add_url = route('lesson-detail-example-index', [$data->pattern_lesson_id, $data->id]);
                // $add_url = route('lesson-detail-add', $data->id);

                return view('partials.action-button')->with(
                    compact('add_url')
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PatternLessonDetail $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        return $model->newQuery()
            // ->where('slug','!=','super-admin')
            ->select([
                'pattern_lesson_details.id',
                'pattern_lesson_details.code',
                'pattern_lesson_details.lesson_title',
                'pattern_lesson_details.pattern_lesson_id',
                'pattern_lesson_details.created_at',
                'pattern_lesson_details.updated_at',
                DB::raw('row_number() over () AS rownum'),
            ])->where('pattern_lesson_details.pattern_lesson_id', '=', $this->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('verb-group-table')
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
            Column::make('lesson_title'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->visible($hasAction)
                ->exportable(false)
                ->printable(true)
                ->width(100)
                ->addClass('text-center'),
            Column::computed('example')
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
        return 'PatternLessonDetail_' . date('YmdHis');
    }
}
