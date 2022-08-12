<?php

namespace App\Http\Controllers\Admin\Suuji;

use App\Http\Requests\SuujiModuleTestRequest;
use App\Models\SuujiModuleTest;
use App\Models\SuujiModules;
use App\Models\SuujiModuleQuestion;
use App\Repositories\SuujiModuleTestRepository;
use App\Http\Controllers\Controller;
use App\DataTables\SuujiModuleTestDatatable;

class SuujiModuleTestController extends Controller
{

    protected $model, $repository, $question, $module;

    public function __construct()
    {
        $this->model = new SuujiModuleTest();
        $this->module = new SuujiModules();
        $this->question = new SuujiModuleQuestion();
        $this->repository = new SuujiModuleTestRepository();
    }

    protected $redirectAfterSave = 'suuji.module.test.index';
    protected $moduleName = 'Suuji Module Test';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SuujiModuleTestDatatable $dataTable)
    {
        $modules = $this->module->isActive()->get();
        $data = $modules[0];
        return $dataTable->render('backend.suuji.module.test.index',compact("data","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->module->isActive()->get();
        return view('backend.suuji.module.test.form',compact("modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuujiModuleTestRequest $request)
    {
        $this->module->data($request->module)->firstOrFail();
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

        $data = $this->model->data($id)->firstOrFail();

        return view('backend.suuji.module.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->model->data($id)->firstOrFail();
        $modules = $this->module->isActive()->get();
        return view('backend.suuji.module.test.form', compact('data','modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuujiModuleTestRequest $request, $id)
    {
        $this->module->data($request->module)->firstOrFail();
        $param = $request->all();
        $saveData = $this->repository->update($param, $id);
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
        $question = $this->question->data("test",$id)->first();
        if($question!=null){
            return "false";
        }

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

    public function module($module){
        $test = $this->model->where("module",$module)->orderBy("order","asc")->get();
        return $test;
    }
}
