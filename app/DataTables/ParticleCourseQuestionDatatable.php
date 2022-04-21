<?php

namespace App\DataTables;

use App\Models\ParticleCourseQuestion;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
// use DB;

class ParticleCourseQuestionDatatable extends DataTable
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
                $edit_url = route('particle-course-questions.edit', $data->id);

                return view('partials.action-button')->with(
                    compact('edit_url')
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ParticleCourseQuestion $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        return $model->newQuery()
            // ->where('slug','!=','super-admin')
            ->select([
                'particle_course_questions.id',
                'particle_course_questions.code',
                'particle_course_questions.question_jpn',
                'particle_course_questions.question_romanji',
                'particle_course_questions.question_idn',
                'particle_course_questions.is_active',
                'particle_course_questions.created_at',
                'particle_course_questions.updated_at',
                'particle_courses.title',
                DB::raw('row_number() over () AS rownum'),
            ])->join('particle_courses', 'particle_courses.id', '=', 'particle_course_questions.particle_course_id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('letter-table')
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
            Column::make('question_jpn')->title('Pertanyaan Jepang'),
            Column::make('question_romanji')->title('Pertanyaan Romaji'),
            Column::make('question_idn')->title('Pertanyaan Indonesia'),
            Column::make('title')->title('Judul Test')->searchable(false),
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
        return 'ParticleCourseQuestion_' . date('YmdHis');
    }
}
