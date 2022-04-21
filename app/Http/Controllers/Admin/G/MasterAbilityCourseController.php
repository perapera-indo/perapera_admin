<?php

namespace App\Http\Controllers\Admin\G;

use App\DataTables\MasterAbilityCourseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterAbilityCourseRequest;
use App\Models\MasterGroup;
use App\Models\MasterAbilityCourse;
use App\Repositories\MasterAbilityCourseRepository;
use Illuminate\Http\Request;

class MasterAbilityCourseController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new MasterAbilityCourse();
        $this->repository = new MasterAbilityCourseRepository();
    }

    protected $redirectAfterSave = 'master-ability-courses.index';
    protected $moduleName = 'Master Ability Course';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MasterAbilityCourseDatatable $datatable)
    {
        return $datatable->render('backend.ability.master.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = MasterGroup::get();
        return view('backend.ability.master.courses.form', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterAbilityCourseRequest $request)
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
        $groups = MasterGroup::get();
        return view('backend.ability.master.courses.form', compact('data', 'groups'));
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
