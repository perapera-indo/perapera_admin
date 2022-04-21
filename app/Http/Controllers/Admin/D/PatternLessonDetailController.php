<?php

namespace App\Http\Controllers\Admin\D;

use App\DataTables\PatternLessonDetailDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatternLessonDetailRequest;
use App\Models\PatternLesson;
use App\Models\PatternChapter;
use App\Models\PatternLessonDetail;
use App\Models\PatternLessonFormula;
use App\Models\PatternLessonHighlight;
use App\Repositories\PatternLessonDetailRepository;
use Illuminate\Http\Request;

class PatternLessonDetailController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new PatternLessonDetail();
        $this->repository = new PatternLessonDetailRepository();
    }

    protected $redirectAfterSave = 'lesson-detail-index';
    protected $moduleName = 'Pattern Lesson Detail';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PatternLessonDetailDatatable $datatable, $did)
    {
        return $datatable->with('id', $did)->render('backend.pattern.lessons.details.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lessons = PatternLesson::where('is_active', 1)->get();
        return view('backend.pattern.lessons.details.form', compact('lessons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatternLessonDetailRequest $request, $id)
    {
        // foreach ($request['highlights'] as $key => $value) {
        //     dd($value);
        // }
        dd($request);
        $param = $request->all();
        $saveData = $this->repository->create($param);
        flashDataAfterSave($saveData, $this->moduleName);

        return redirect()->route($this->redirectAfterSave, $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $did)
    {
        if (isOnlyDataOwned()) {
            $data = $this->model
                ->where('created_by', '=', user_info('id'))
                ->where('id', '=', $did)
                ->firstOrFail();
        } else {
            $data = $this->model->findOrFail($did);
        }
        // dd($did);
        $chapters = PatternChapter::where('is_active', 1)->get();
        $highlights = PatternLessonHighlight::where('pattern_lesson_detail_id', $did)->get();
        $formulas = PatternLessonFormula::where('pattern_lesson_detail_id', $did)->get();
        return view('backend.pattern.lessons.details.edit-form', compact('data', 'highlights', 'formulas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $did)
    {

        $param = $request->all();
        $saveData = $this->repository->update($param, $id, $did);
        flashDataAfterSave($saveData, $this->moduleName);

        return redirect()->route($this->redirectAfterSave, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $this->repository->delete($id);
    // }
}
