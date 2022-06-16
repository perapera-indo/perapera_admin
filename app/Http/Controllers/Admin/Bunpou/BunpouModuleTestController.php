<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouModuleTestRequest;
use App\Models\BunpouModuleTest;
use App\Models\BunpouModules;
use App\Models\BunpouModuleQuestion;
use App\Repositories\BunpouModuleTestRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouModuleTestDatatable;

class BunpouModuleTestController extends Controller
{

    protected $model, $repository, $question, $module;

    public function __construct()
    {
        $this->model = new BunpouModuleTest();
        $this->module = new BunpouModules();
        $this->question = new BunpouModuleQuestion();
        $this->repository = new BunpouModuleTestRepository();
    }

    protected $redirectAfterSave = 'bunpou.module.test.index';
    protected $moduleName = 'Bunpou Module Test';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouModuleTestDatatable $dataTable)
    {
        $modules = $this->module->isActive()->get();
        $data = $modules[0];
        return $dataTable->render('backend.bunpou.module.test.index',compact("data","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->module->isActive()->get();
        return view('backend.bunpou.module.test.form',compact("modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouModuleTestRequest $request)
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

        return view('backend.bunpou.module.show', compact('data'));
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
        return view('backend.bunpou.module.test.form', compact('data','modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BunpouModuleTestRequest $request, $id)
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
