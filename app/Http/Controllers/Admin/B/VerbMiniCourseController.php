<?php

namespace App\Http\Controllers\Admin\B;

use App\DataTables\VerbMiniCourseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerbMiniCourseRequest;
use App\Http\Requests\verbRequest;
use App\Models\MasterVerbLevel;
use App\Models\VerbMiniCourse;
use App\Repositories\VerbMiniCourseRepository;
use Illuminate\Http\Request;

class VerbMiniCourseController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new VerbMiniCourse();
        $this->repository = new VerbMiniCourseRepository();
    }

    protected $redirectAfterSave = 'verb-mini-courses.index';
    protected $moduleName = 'verb mini courses';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VerbMiniCourseDatatable $datatable)
    {
        return $datatable->render('backend.verbs.mini.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = MasterVerbLevel::where('is_active', 1)->get();
        return view('backend.verbs.mini.courses.form', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VerbMiniCourseRequest $request)
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
        $levels = MasterVerbLevel::where('is_active', 1)->get();
        return view('backend.verbs.mini.courses.form', compact('data', 'levels'));
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
