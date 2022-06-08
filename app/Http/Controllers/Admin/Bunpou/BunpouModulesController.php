<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouModulesRequest;
use App\Models\BunpouModules;
use App\Models\BunpouChapters;
use App\Repositories\BunpouModulesRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouModulesDatatable;

class BunpouModulesController extends Controller
{

    protected $model, $repository, $chapter;

    public function __construct()
    {
        $this->model = new BunpouModules();
        $this->chapter = new BunpouChapters();
        $this->repository = new BunpouModulesRepository();
    }

    protected $redirectAfterSave = 'bunpou.module.index';
    protected $moduleName = 'Bunpou Module';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouModulesDatatable $dataTable)
    {
        return $dataTable->render('backend.bunpou.module.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.bunpou.module.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouModulesRequest $request)
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
    public function update(BunpouModulesRequest $request, $id)
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

    public function activate($id)
    {
        return $this->repository->activate($id);
    }

    public function deactivate($id)
    {
        return $this->repository->deactivate($id);
    }
}
