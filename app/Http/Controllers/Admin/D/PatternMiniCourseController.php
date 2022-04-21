<?php

namespace App\Http\Controllers\Admin\D;

use App\DataTables\PatternMiniCourseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatternMiniCourseRequest;
use App\Models\MasterGroup;
use App\Models\PatternMiniCourse;
use App\Models\patternEducation;
use App\Models\PatternLesson;
use App\Repositories\PatternMiniCourseRepository;
use Illuminate\Http\Request;

class PatternMiniCourseController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new PatternMiniCourse();
        $this->repository = new PatternMiniCourseRepository();
    }

    protected $redirectAfterSave = 'pattern-mini-courses.index';
    protected $moduleName = 'Pattern Mini Courses';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PatternMiniCourseDatatable $datatable)
    {
        return $datatable->render('backend.pattern.mini.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $lessons = PatternLesson::where('is_active', 1)->get();
        $groups = MasterGroup::where('is_active', 1)->get();
        return view('backend.pattern.mini.courses.form', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatternMiniCourseRequest $request)
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
        $groups = MasterGroup::where('is_active', 1)->get();
        return view('backend.pattern.mini.courses.form', compact('data','groups'));
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
        $saveData = $this->repository->updatecourse($param, $id);
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
