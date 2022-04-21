<?php

namespace App\Http\Controllers\Admin\C;

use App\DataTables\ParticleMiniCourseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParticleMiniCourseRequest;
use App\Models\ParticleMiniCourse;
use App\Models\ParticleEducationChapter;
use App\Repositories\ParticleMiniCourseRepository;
use Illuminate\Http\Request;

class ParticleMiniCourseController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new ParticleMiniCourse();
        $this->repository = new ParticleMiniCourseRepository();
    }

    protected $redirectAfterSave = 'particle-mini-courses.index';
    protected $moduleName = 'Particle Mini Courses';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ParticleMiniCourseDatatable $datatable)
    {
        return $datatable->render('backend.particle.mini.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $educations = ParticleEducationChapter::where('is_active', 1)->get();
        return view('backend.particle.mini.courses.form', compact('educations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParticleMiniCourseRequest $request)
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
        $educations = ParticleEducationChapter::where('is_active', 1)->get();
        return view('backend.particle.mini.courses.form', compact('data', 'educations'));
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
