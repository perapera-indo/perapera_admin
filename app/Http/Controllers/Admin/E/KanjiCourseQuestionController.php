<?php

namespace App\Http\Controllers\Admin\E;

use App\DataTables\KanjiCourseQuestionDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\KanjiCourseQuestionRequest;
use App\Models\KanjiCourse;
use App\Models\KanjiCourseAnswer;
use App\Models\KanjiCourseQuestion;
use App\Repositories\KanjiCourseQuestionRepository;
use Illuminate\Http\Request;

class KanjiCourseQuestionController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new KanjiCourseQuestion();
        $this->repository = new KanjiCourseQuestionRepository();
    }

    protected $redirectAfterSave = 'kanji-course-questions.index';
    protected $moduleName = 'Kanji Courses Questions';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanjiCourseQuestionDatatable $datatable)
    {
        return $datatable->render('backend.kanji.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = KanjiCourse::get();
        $type = "new";
        return view('backend.kanji.questions.form', compact('courses','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KanjiCourseQuestionRequest $request)
    {
        // dd($request);
        $param = $request->all();
        $saveData = $this->repository->createNew($param);
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
    public function edit($id)
    {
        if (isOnlyDataOwned()) {
            $data = $this->model
                ->where('created_by', '=', user_info('id'))
                ->where('id', '=', $id)
                ->firstOrFail();
        } else {
            $data = $this->model->findOrFail($id);
        }
        $courses = KanjiCourse::get();
        $answers = KanjiCourseAnswer::where('kanji_course_question_id', $id)->orderBy('id','ASC')->get();
        $type = "edit";
        return view('backend.kanji.questions.form', compact('data', 'courses','answers', 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $param = $request->all();
        $saveData = $this->repository->update($param, $id);
        flashDataAfterSave($saveData, $this->moduleName);

        return redirect()->route($this->redirectAfterSave);
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
