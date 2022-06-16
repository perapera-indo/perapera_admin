<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouChaptersRequest;
use App\Models\BunpouChapters;
use App\Models\BunpouModules;
use App\Models\BunpouVocab;
use App\Models\BunpouParticle;
use App\Repositories\BunpouChaptersRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouChaptersDatatable;

class BunpouChaptersController extends Controller
{

    protected $model, $repository, $module, $vocab, $particle;

    public function __construct()
    {
        $this->model = new BunpouChapters();
        $this->vocab = new BunpouVocab();
        $this->module = new BunpouModules();
        $this->particle = new BunpouParticle();
        $this->repository = new BunpouChaptersRepository();
    }

    protected $redirectAfterSave = 'bunpou.chapter.index';
    protected $moduleName = 'Bunpou Chapter';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouChaptersDatatable $dataTable)
    {
        $modules = $this->module->isActive()->get();
        $data = $modules[0];
        return $dataTable->render('backend.bunpou.chapter.index',compact("data","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->module->isActive()->get();
        return view('backend.bunpou.chapter.form',compact("modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouChaptersRequest $request)
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
        return view('backend.bunpou.chapter.form', compact('data','modules'));
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
        $chapter = $this->model->data($id)->firstOrFail();
        $vocab = $this->vocab->data("chapter",$chapter->id)->first();
        if($vocab!=null){
            return "false";
        }
        $particle = $this->particle->data("chapter",$chapter->id)->first();
        if($particle!=null){
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
        $chapter = $this->model->withCount()->where("module",$module)->get();
        return $chapter;
    }
}
