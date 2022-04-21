<?php

namespace App\Http\Controllers\Admin\D;

use App\DataTables\PatternLessonExampleDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatternLessonExampleRequest;
use App\Models\PatternLesson;
use App\Models\PatternChapter;
use App\Models\PatternLessonDetail;
use App\Models\PatternLessonExample;
use App\Models\PatternLessonExampleJapan;
use App\Models\PatternLessonExampleRomanji;
use App\Models\PatternLessonFormula;
use App\Models\PatternLessonHighlight;
use App\Repositories\PatternLessonExampleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatternLessonDetailExampleController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new PatternLessonExample();
        $this->repository = new PatternLessonExampleRepository();
    }

    protected $redirectAfterSave = 'lesson-detail-example-index';
    protected $moduleName = 'Pattern Lesson Detail Example';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PatternLessonExampleDatatable $datatable, $eid)
    {
        return $datatable->with('id', $eid)->render('backend.pattern.lessons.examples.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lessons = PatternLesson::where('is_active', 1)->get();
        return view('backend.pattern.lessons.examples.form', compact('lessons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatternLessonExampleRequest $request)
    {
        // foreach ($request['highlights'] as $key => $value) {
        //     dd($value);
        // }
        // dd($request);
        // dd($request['example_japans']);
        $param = $request->all();
        // dd($param);
        $saveData = $this->repository->create($param);
        flashDataAfterSave($saveData, $this->moduleName);

        return redirect()->route($this->redirectAfterSave);
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
    public function edit($id, $did, $eid)
    {
        if (isOnlyDataOwned()) {
            $data = $this->model
                ->where('created_by', '=', user_info('id'))
                ->where('id', '=', $eid)
                ->firstOrFail();
        } else {
            $data = $this->model
                ->select('pattern_lesson_examples.id', 'pattern_lesson_examples.code', 'img', 'text_idn', 'pattern_lesson_detail_id', 'pattern_lesson_id')
                ->join('pattern_lesson_details', 'pattern_lesson_details.id', '=', 'pattern_lesson_examples.pattern_lesson_detail_id')
                ->findOrFail($eid);
        }
        // dd($data);
        $exJapans = PatternLessonExampleJapan::where('pattern_lesson_example_id', $eid)->get();
        $exRomanjis = PatternLessonExampleRomanji::where('pattern_lesson_example_id', $eid)->get();
        // dd($exJapans);
        // $chapters = PatternChapter::where('is_active', 1)->get();
        // $highlights = PatternLessonHighlight::where('pattern_lesson_detail_id', $did)->get();
        // $formulas = PatternLessonFormula::where('pattern_lesson_detail_id', $did)->get();
        return view('backend.pattern.lessons.examples.edit-form', compact('data', 'exJapans', 'exRomanjis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $did, $eid)
    {

        $param = $request->all();
        // dd($param);
        $saveData = $this->repository->update($param, $id, $did, $eid);
        flashDataAfterSave($saveData, $this->moduleName);

        return redirect()->route($this->redirectAfterSave, [$id, $did, $eid]);
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
