<?php

namespace App\Http\Controllers\Admin\D;

use App\DataTables\PatternCourseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatternCourseRequest;
use App\Models\PatternCourse;
use App\Models\patternEducation;
use App\Repositories\PatternCourseRepository;
use Illuminate\Http\Request;

class PatternCourseController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new PatternCourse();
        $this->repository = new PatternCourseRepository();
    }

    protected $redirectAfterSave = 'pattern-courses.index';
    protected $moduleName = 'Pattern Courses';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PatternCourseDatatable $datatable)
    {
        return $datatable->render('backend.pattern.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $educations = patternEducation::where('is_active', 1)->get();
        return view('backend.pattern.courses.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatternCourseRequest $request)
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
        // $educations = patternEducation::where('is_active', 1)->get();
        return view('backend.pattern.courses.form', compact('data'));
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
