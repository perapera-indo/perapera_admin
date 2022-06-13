<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouChaptersRequest;
use App\Models\BunpouChapters;
use App\Models\BunpouModules;
use App\Repositories\BunpouChaptersRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouChaptersDatatable;

class BunpouChaptersController extends Controller
{

    protected $model, $repository, $module;

    public function __construct()
    {
        $this->model = new BunpouChapters();
        $this->module = new BunpouModules();
        $this->repository = new BunpouChaptersRepository();
    }

    protected $redirectAfterSave = 'bunpou.chapter.index';
    protected $moduleName = 'Bunpou Chapter';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouChaptersDatatable $dataTable, $module=null)
    {
        if($module==null){
            return redirect()->route("bunpou.module.index");
        }

        $data = $this->module->data($module)->firstOrFail();
        $modules = $this->module->isActive()->get();
        return $dataTable->render('backend.bunpou.chapter.index',compact("data","modules"));
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
        $module = $this->module->data($module)->firstOrFail();
        return view('backend.bunpou.chapter.form',compact("module"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouChaptersRequest $request)
    {
        $module = $this->module->data($request->module)->firstOrFail();
        $param = $request->all();
        $saveData = $this->repository->create($param);
        flashDataAfterSave($saveData,$this->moduleName);

        return redirect()->route($this->redirectAfterSave,$module->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $module = $this->module->data($data->module)->firstOrFail();

        return view('backend.bunpou.chapter.form', compact('data','module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BunpouChaptersRequest $request, $id)
    {
        $module = $this->module->data($request->module)->firstOrFail();
        $param = $request->all();
        $saveData = $this->repository->update($param, $id);
        flashDataAfterSave($saveData,$this->moduleName);

        return redirect()->route($this->redirectAfterSave,$module->id);
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

    public function redirect(){
        $module = $this->module->isActive()->firstOrFail();
        return redirect()->route($this->redirectAfterSave,$module->id);
    }
}
