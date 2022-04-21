<?php

namespace App\Http\Controllers\Admin\F;

use App\DataTables\VocabularyMiniCourseQuestionDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\VocabularyMiniCourseQuestionRequest;
use App\Models\VocabularyMiniCourse;
use App\Models\VocabularyMiniCourseAnswer;
use App\Models\VocabularyMiniCourseQuestion;
use App\Repositories\VocabularyMiniCourseQuestionRepository;
use Illuminate\Http\Request;

class VocabularyMiniCourseQuestionController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new VocabularyMiniCourseQuestion();
        $this->repository = new VocabularyMiniCourseQuestionRepository();
    }

    protected $redirectAfterSave = 'vocabulary-mini-course-questions.index';
    protected $moduleName = 'Vocabulary Courses Questions';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VocabularyMiniCourseQuestionDatatable $datatable)
    {
        return $datatable->render('backend.vocabulary.mini.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = VocabularyMiniCourse::select('vocabulary_mini_courses.*', 'vocabulary_chapters.id as chp_id', 'vocabulary_chapters.name')
            ->join('vocabulary_chapters', 'vocabulary_chapters.id', '=', 'vocabulary_mini_courses.vocabulary_chapter_id')
            ->where('vocabulary_mini_courses.is_active', 1)
            ->orderBy('title', 'ASC')
            ->get();

        $type = "new";
        return view('backend.vocabulary.mini.questions.form', compact('courses', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VocabularyMiniCourseQuestionRequest $request)
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

        $courses = VocabularyMiniCourse::select('vocabulary_mini_courses.*', 'vocabulary_chapters.id as chp_id', 'vocabulary_chapters.name')
            ->join('vocabulary_chapters', 'vocabulary_chapters.id', '=', 'vocabulary_mini_courses.vocabulary_chapter_id')
            ->where('vocabulary_mini_courses.is_active', 1)
            ->orderBy('title', 'ASC')
            ->get();

        $answers = VocabularyMiniCourseAnswer::where('vocabulary_mini_course_question_id', $id)->orderBy('id', 'ASC')->get();
        $type = "edit";
        return view('backend.vocabulary.mini.questions.form', compact('data', 'courses', 'answers', 'type'));
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
