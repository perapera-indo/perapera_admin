<?php

namespace App\Http\Controllers\Admin\D;

use App\DataTables\PatternCourseQuestionDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatternCourseQuestionRequest;
use App\Models\PatternCourse;
use App\Models\PatternCourseAnswer;
use App\Models\PatternCourseQuestion;
use App\Repositories\PatternCourseQuestionRepository;
use Illuminate\Http\Request;

class PatternCourseQuestionController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new PatternCourseQuestion();
        $this->repository = new PatternCourseQuestionRepository();
    }

    protected $redirectAfterSave = 'pattern-course-questions.index';
    protected $moduleName = 'Pattern Courses Questions';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PatternCourseQuestionDatatable $datatable)
    {
        return $datatable->render('backend.pattern.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = PatternCourse::get();
        $type = "new";
        return view('backend.pattern.questions.form', compact('courses','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatternCourseQuestionRequest $request)
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
        $courses = PatternCourse::get();
        $answers = PatternCourseAnswer::where('pattern_course_question_id', $id)->orderBy('id','ASC')->get();
        $type = "edit";
        return view('backend.pattern.questions.form', compact('data', 'courses','answers', 'type'));
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
