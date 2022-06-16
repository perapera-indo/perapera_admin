<?php

namespace App\DataTables;

use App\Models\BunpouModuleQuestion;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
// use DB;

class BunpouModuleQuestionDatatable extends DataTable
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
            ->addColumn('action', function($question){
                $__route_name = 'bunpou.module.question.edit';
                $__route_name_delete = 'bunpou.module.question.destroy';
                $edit_url = route($__route_name, $question->id);
                $delete_url = route($__route_name_delete, $question->id);

                return view('partials.action-button')->with(
                    compact('edit_url','delete_url','__route_name','__route_name_delete')
                );
            })
            ->editColumn('image', function ($question) {
                if(empty($question->image)){
                    $color = "secondary";
                    $text = "No Image Uploaded";
                    return view('partials.badge')->with(
                        compact('color','text')
                    );
                }

                $download_url = asset($question->image);
                $download_blank = true;
                return view('partials.action-button')->with(
                    compact('download_url','download_blank')
                );
            })
            ->editColumn('audio', function ($question) {
                if(empty($question->audio)){
                    $color = "secondary";
                    $text = "No Audio Uploaded";
                    return view('partials.badge')->with(
                        compact('color','text')
                    );
                }

                $download_url = asset($question->audio);
                $download_blank = true;
                return view('partials.action-button')->with(
                    compact('download_url','download_blank')
                );
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\BunpouModuleQuestion $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BunpouModuleQuestion $model)
    {
        // DB::statement(DB::raw('set @rownum=0'));
        $query = $model->newQuery()
            ->select([
                'id',
                'question',
                'image',
                'audio',
                'test',
                'order',
                'is_active',
                DB::raw('row_number() over () AS rownum'),
            ])
            ->where("test",$this->request->test);

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $id = 'bunpou-module-question-dt';
        $domScript = "data.module = $('#$id-module').val(); data.test = $('#$id-test').val();";
        $stateSaveScript = "function(settings, data){
            data.search.search = data.search.search
            data.module = data.module ? data.module : $('#$id-module').val()
            data.test = data.test ? data.test : $('#$id-test').val()
        }";

        return $this->builder()
                    ->setTableId($id)
                    ->columns($this->getColumns())
                    ->minifiedAjax("",$domScript)
                    ->dom('<"row"<"col-sm-3 section-module"><"col-sm-3 section-test"><"col-sm-3"><"col-sm-3"f>> <"row"<"col-sm-12"tr>> <"row"<"col-sm-4"l><"col-sm-3"i><"col-sm-5"p>>')
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
            Column::make('order')
                ->name('order')
                ->title('Number')
                ->width("10%")
                ->addClass('text-center'),
            Column::make('question')
                ->name('question')
                ->title('Question'),
            Column::make('image')
                ->name('image')
                ->title('Image')
                ->width("10%")
                ->addClass('text-center')
                ->searchable(false)
                ->exportable(false)
                ->printable(true),
            Column::make('audio')
                ->name('audio')
                ->title('Audio')
                ->width("10%")
                ->addClass('text-center')
                ->searchable(false)
                ->exportable(false)
                ->printable(true),
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
