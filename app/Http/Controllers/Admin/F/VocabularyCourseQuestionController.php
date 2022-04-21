<?php

namespace App\Http\Controllers\Admin\F;

use App\DataTables\VocabularyCourseQuestionDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\VocabularyCourseQuestionRequest;
use App\Models\VocabularyCourse;
use App\Models\VocabularyCourseAnswer;
use App\Models\VocabularyCourseQuestion;
use App\Repositories\VocabularyCourseQuestionRepository;
use Illuminate\Http\Request;

class VocabularyCourseQuestionController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new VocabularyCourseQuestion();
        $this->repository = new VocabularyCourseQuestionRepository();
    }

    protected $redirectAfterSave = 'vocabulary-course-questions.index';
    protected $moduleName = 'Vocabulary Courses Questions';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VocabularyCourseQuestionDatatable $datatable)
    {
        return $datatable->render('backend.vocabulary.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = VocabularyCourse::select('vocabulary_courses.*', 'vocabulary_course_chapters.id as chp_id', 'vocabulary_course_chapters.title as chapter_title')
            ->join('vocabulary_course_chapters', 'vocabulary_course_chapters.id', '=', 'vocabulary_courses.vocabulary_course_chapter_id')
            ->where('vocabulary_courses.is_active', 1)
            ->groupBy('chp_id', 'chapter_title', 'vocabulary_courses.id')
            ->get();

        $type = "new";

        return view('backend.vocabulary.questions.form', compact('courses', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VocabularyCourseQuestionRequest $request)
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

        $courses = VocabularyCourse::select('vocabulary_courses.*', 'vocabulary_course_chapters.id as chp_id', 'vocabulary_course_chapters.title as chapter_title')
            ->join('vocabulary_course_chapters', 'vocabulary_course_chapters.id', '=', 'vocabulary_courses.vocabulary_course_chapter_id')
            ->where('vocabulary_courses.is_active', 1)
            ->groupBy('chp_id', 'chapter_title', 'vocabulary_courses.id')
            ->get();

        $answers = VocabularyCourseAnswer::where('vocabulary_course_question_id', $id)->orderBy('id', 'ASC')->get();
        $type = "edit";

        return view('backend.vocabulary.questions.form', compact('data', 'courses', 'answers', 'type'));
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
