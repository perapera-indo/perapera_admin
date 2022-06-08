<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouModuleTestRequest;
use App\Models\BunpouModules;
use App\Models\BunpouChapters;
use App\Repositories\BunpouModulesRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouModuleTestDatatable;

class BunpouModuleTestController extends Controller
{

    protected $model, $repository, $chapter;

    public function __construct()
    {
        $this->model = new BunpouModules();
        $this->chapter = new BunpouChapters();
        $this->repository = new BunpouModulesRepository();
    }

    protected $redirectAfterSave = 'bunpou.module.test.index';
    protected $moduleName = 'Bunpou Module Test';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouModuleTestDatatable $dataTable, $module=null)
    {
        if($module==null){
            return redirect()->route("bunpou.module.index");
        }

        $data = $this->model->data($module)->firstOrFail();

        return $dataTable->render('backend.bunpou.module.test.index',compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($module=null)
    {
        if($module==null){
            return redirect()->route("bunpou.module.index");
        }
        $module = $this->model->data($module)->firstOrFail();
        return view('backend.bunpou.module.test.form',compact("module"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouModuleTestRequest $request, $module=null)
    {
        if($module==null){
            return redirect()->route("bunpou.module.index");
        }
        $module = $this->model->data($module)->firstOrFail();

        $param = $request->all();
        $saveData = $this->repository->create($param);
        flashDataAfterSave($saveData,$this->moduleName);

        return redirect()->route($this->redirectAfterSave,$module);

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

        return view('backend.bunpou.module.form', compact('data'));
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
        $chapter = $this->chapter->data("module",$id)->first();
        if($chapter!=null){
            return "false";
        }

        return $this->repository->delete($id);
    }
}
