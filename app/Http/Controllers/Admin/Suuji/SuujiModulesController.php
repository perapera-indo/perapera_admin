<?php

namespace App\Http\Controllers\Admin\Suuji;

use App\Http\Requests\SuujiModulesRequest;
use App\Models\SuujiModules;
use App\Repositories\SuujiModulesRepository;
use App\Http\Controllers\Controller;
use App\DataTables\SuujiModulesDatatable;

class SuujiModulesController extends Controller
{

    protected $repository, $module;

    public function __construct()
    {
        $this->module = new SuujiModules();
        $this->repository = new SuujiModulesRepository();
    }

    protected $redirectAfterSave = 'suuji.module.index';
    protected $moduleName = 'Suuji Module';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SuujiModulesDatatable $dataTable)
    {
        return $dataTable->render('backend.suuji.module.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.suuji.module.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuujiModulesRequest $request)
    {
        $param = $request->all();
        $saveData = $this->repository->create($param);
        flashDataAfterSave($saveData,$this->moduleName);

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
        $data = $this->module->data($id)->firstOrFail();

        return view('backend.suuji.module.form',compact("data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuujiModulesRequest $request, $id)
    {
        $param = $request->all();
        $saveData = $this->repository->update($id,$param);
        flashDataAfterSave($saveData,$this->moduleName);

        return redirect()->route($this->redirectAfterSave);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);
    }

    public function activate($id)
    {
        return $this->repository->activate($id);
    }

    public function deactivate($id)
    {
        return $this->repository->deactivate($id);
    }
}
