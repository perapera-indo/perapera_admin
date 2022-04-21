<?php

namespace App\Http\Controllers\Admin\B;

use App\DataTables\VerbQuestionDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerbCourseQuestionRequest;
use App\Http\Requests\LetterRequest;
use App\Models\VerbCourse;
use App\Models\VerbCourseAnswer;
use App\Models\VerbCourseQuestion;
use App\Repositories\VerbQuestionRepository;
use Illuminate\Http\Request;

class VerbCourseQuestionController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new VerbCourseQuestion();
        $this->repository = new VerbQuestionRepository();
    }

    protected $redirectAfterSave = 'verb-questions.index';
    protected $moduleName = 'verb-courses-questions';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VerbQuestionDatatable $datatable)
    {
        return $datatable->render('backend.verbs.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $courses = VerbCourse::get();
        $courses = VerbCourse::select('verb_courses.id', 'verb_courses.title', 'master_verb_levels.id as level_id', 'master_verb_levels.name as level_name')
        ->join('master_verb_levels', 'master_verb_levels.id', '=', 'verb_courses.master_verb_level_id')
        ->where('verb_courses.is_active', 1)
        ->groupBy('level_id', 'verb_courses.title', 'level_name','verb_courses.id')
        ->get();

        $type = "new";

        return view('backend.verbs.questions.form', compact('courses','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VerbCourseQuestionRequest $request)
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
        // $courses = VerbCourse::get();
        $courses = VerbCourse::select('verb_courses.id', 'verb_courses.title', 'master_verb_levels.id as level_id', 'master_verb_levels.name as level_name')
        ->join('master_verb_levels', 'master_verb_levels.id', '=', 'verb_courses.master_verb_level_id')
        ->where('verb_courses.is_active', 1)
        ->groupBy('level_id', 'verb_courses.title', 'level_name','verb_courses.id')
        ->get();

        $answers = VerbCourseAnswer::where('verb_course_question_id', $id)->orderBy('id','ASC')->get();
        $type = "edit";
        return view('backend.verbs.questions.form', compact('data', 'courses','answers', 'type'));
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
