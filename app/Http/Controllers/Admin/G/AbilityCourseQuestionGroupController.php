<?php

namespace App\Http\Controllers\Admin\G;

use App\DataTables\AbilityCourseQuestionGroupDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AbilityCourseQuestionGroupRequest;
use App\Models\AbilityCourse;
use App\Models\AbilityCourseAnswer;
use App\Models\AbilityCourseQuestionGroup;
use App\Repositories\AbilityCourseQuestionGroupRepository;
use Illuminate\Http\Request;

class AbilityCourseQuestionGroupController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new AbilityCourseQuestionGroup();
        $this->repository = new AbilityCourseQuestionGroupRepository();
    }

    protected $redirectAfterSave = 'ability-course-question-groups.index';
    protected $moduleName = 'ability Courses Questions Group';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AbilityCourseQuestionGroupDatatable $datatable)
    {
        return $datatable->render('backend.ability.questions.groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = AbilityCourse::where('is_active', 1)->get();
        $type = "new";
        return view('backend.ability.questions.groups.form', compact('courses','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbilityCourseQuestionGroupRequest $request)
    {
        // dd($request);
        $param = $request->all();
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
        $courses = AbilityCourse::where('is_active', 1)->get();
        $type = "edit";
        return view('backend.ability.questions.groups.form', compact('data', 'courses','type'));
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
