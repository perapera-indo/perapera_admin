<?php

namespace App\Http\Controllers\Admin\G;

use App\DataTables\AbilityCourseQuestionDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AbilityCourseQuestionRequest;
use App\Models\AbilityCourse;
use App\Models\AbilityCourseAnswer;
use App\Models\AbilityCourseQuestion;
use App\Repositories\AbilityCourseQuestionRepository;
use Illuminate\Http\Request;

class AbilityCourseQuestionController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new AbilityCourseQuestion();
        $this->repository = new AbilityCourseQuestionRepository();
    }

    protected $redirectAfterSave = 'ability-questions.index';
    protected $moduleName = 'ability Courses Questions';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AbilityCourseQuestionDatatable $datatable, $id)
    {
        // dd($id);
        return $datatable->with('id', $id)->render('backend.ability.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = AbilityCourse::get();
        $type = "new";
        return view('backend.ability.questions.form', compact('courses', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbilityCourseQuestionRequest $request)
    {
        // dd($request['ability_course_question_group_id']);
        $param = $request->all();
        $saveData = $this->repository->createNew($param);
        flashDataAfterSave($saveData, $this->moduleName);

        return redirect()->route($this->redirectAfterSave, $request['ability_course_question_group_id']);
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
    public function edit($id, $ability_question)
    {
        if (isOnlyDataOwned()) {
            $data = $this->model
                ->where('created_by', '=', user_info('id'))
                ->where('id', '=', $ability_question)
                ->firstOrFail();
        } else {
            $data = $this->model->findOrFail($ability_question);
        }

        $courses = AbilityCourse::where('is_active', 1)->get();
        $answers = AbilityCourseAnswer::where('ability_course_question_id', $ability_question)->get();
        $type = "edit";
        return view('backend.ability.questions.form', compact('data', 'courses', 'answers', 'type'));
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

        return redirect()->route($this->redirectAfterSave, $param['ability_course_question_group_id']);
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
