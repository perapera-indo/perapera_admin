<?php

namespace App\Http\Controllers\Admin\B;

use App\DataTables\MasterVerbGroupDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterVerbGroupRequest;
use App\Models\MasterVerbGroup;
use App\Models\MasterVerbLevel;
use App\Repositories\MasterVerbGroupRepository;
use Illuminate\Http\Request;

class MasterVerbGroupController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new MasterVerbGroup();
        $this->repository = new MasterVerbGroupRepository();
    }

    protected $redirectAfterSave = 'verb-groups.index';
    protected $moduleName = 'verb_groups';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MasterVerbGroupDatatable $datatable)
    {
        return $datatable->render('backend.verbs.groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = MasterVerbLevel::where('is_active', 1)->get();
        $parents = MasterVerbGroup::whereNull('parent_id')->where('is_active', 1)->get();
        // dd($parents);
        return view('backend.verbs.groups.form', compact('levels', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterVerbGroupRequest $request)
    {
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
        $parents = MasterVerbGroup::whereNull('parent_id')->where('id', '!=', $id)->where('is_active', 1)->get();
        return view('backend.verbs.groups.form', compact('data', 'levels', 'parents'));
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
