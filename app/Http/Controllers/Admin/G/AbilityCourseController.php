<?php

namespace App\Http\Controllers\Admin\G;

use App\DataTables\AbilityCourseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AbilityCourseRequest;
use App\Models\AbilityCourse;
use App\Models\AbilityCourseChapter;
use App\Repositories\AbilityCourseRepository;
use Illuminate\Http\Request;

class AbilityCourseController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new AbilityCourse();
        $this->repository = new AbilityCourseRepository();
    }

    protected $redirectAfterSave = 'ability-courses.index';
    protected $moduleName = 'ability courses';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AbilityCourseDatatable $datatable)
    {
        return $datatable->render('backend.ability.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapters = AbilityCourseChapter::where('is_active', 1)->get();
        return view('backend.ability.courses.form', compact('chapters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbilityCourseRequest $request)
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

        $chapters = AbilityCourseChapter::where('is_active', 1)->get();

        return view('backend.ability.courses.form', compact('data', 'chapters'));
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
