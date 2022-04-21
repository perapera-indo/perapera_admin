<?php

namespace App\Http\Controllers\Admin\A;

use App\DataTables\LetterQuestionDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\LetterCourseQuestionRequest;
use App\Http\Requests\LetterRequest;
use App\Models\LetterCourse;
use App\Models\LetterCourseAnswer;
use App\Models\LetterCourseQuestion;
use App\Repositories\LetterQuestionRepository;
use Illuminate\Http\Request;

class LetterCourseQuestionController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new LetterCourseQuestion();
        $this->repository = new LetterQuestionRepository();
    }

    protected $redirectAfterSave = 'letter-questions.index';
    protected $moduleName = 'letter-courses-questions';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LetterQuestionDatatable $datatable)
    {
        return $datatable->render('backend.letters.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd($courses);
        $courses = LetterCourse::select('letter_courses.*', 'letter_categories.id as cat_id', 'letter_categories.name')
            ->join('letter_categories', 'letter_categories.id', '=', 'letter_courses.letter_category_id')
            ->where('letter_courses.is_active', 1)
            ->groupBy('cat_id', 'name', 'letter_courses.id')
            ->get();

        $type = "new";
        return view('backend.letters.questions.form', compact('courses', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LetterCourseQuestionRequest $request)
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

        $courses = LetterCourse::select('letter_courses.*', 'letter_categories.id as cat_id', 'letter_categories.name')
            ->join('letter_categories', 'letter_categories.id', '=', 'letter_courses.letter_category_id')
            ->where('letter_courses.is_active', 1)
            ->groupBy('cat_id','name','letter_courses.id')
            ->get();

        $answers = LetterCourseAnswer::where('letter_course_question_id', $id)->orderBy('id','ASC')->get();
        $type = "edit";
        return view('backend.letters.questions.form', compact('data', 'courses', 'answers', 'type'));
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
        $saveData = $this->repository->updateLetter($param, $id);
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
