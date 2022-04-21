<?php

namespace App\Http\Controllers\Admin\G;

use App\DataTables\MasterAbilityCourseLevelDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterAbilityCourseLevelRequest;
use App\Http\Requests\verbRequest;
use App\Models\MasterVerbLevel;
use App\Models\MasterAbilityCourseLevel;
use App\Repositories\MasterAbilityCourseLevelRepository;
use Illuminate\Http\Request;

class MasterAbilityCourseLevelController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new MasterAbilityCourseLevel();
        $this->repository = new MasterAbilityCourseLevelRepository();
    }

    protected $redirectAfterSave = 'master-ability-course-levels.index';
    protected $moduleName = 'Master Ability Course Level';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MasterAbilityCourseLevelDatatable $datatable)
    {
        return $datatable->render('backend.ability.master.levels.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.ability.master.levels.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterAbilityCourseLevelRequest $request)
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

        return view('backend.ability.master.levels.form', compact('data'));
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
