<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouParticleTestRequest;
use App\Models\BunpouModules;
use App\Models\BunpouChapters;
use App\Models\BunpouParticle;
use App\Models\BunpouParticleTest;
use App\Repositories\BunpouParticleTestRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouParticleTestDatatable;

class BunpouParticleTestController extends Controller
{

    protected $module, $chapter, $particle, $repository, $test;

    public function __construct()
    {
        $this->module = new BunpouModules();
        $this->particle = new BunpouParticle();
        $this->repository = new BunpouParticleTestRepository();
        $this->test = new BunpouParticleTest();
        $this->chapter = new BunpouChapters();
    }

    protected $redirectAfterSave = 'bunpou.particle.test.index';
    protected $moduleName = 'Bunpou Particle Test';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouParticleTestDatatable $dataTable)
    {
        $modules = $this->module->withChapterCount();
        $data = request()->module!=null
            ? $this->module->data(request()->module)->firstOrFail()
            : $modules[0];
        return $dataTable->render('backend.bunpou.particle.test.index',compact("data","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->module->withChapterCount();
        return view('backend.bunpou.particle.test.form',compact("modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouParticleTestRequest $request)
    {
        $this->chapter->data($request->chapter)->firstOrFail();
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
        $modules = $this->module->withChapterCount();
        $data = $this->test->data($id)->firstOrFail();
        $chapter = $this->chapter->data($data->chapter)->firstOrFail();
        return view('backend.bunpou.particle.test.form',compact("modules","chapter","data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BunpouParticleTestRequest $request, $id)
    {
        $this->particle->data($request->particle)->firstOrFail();
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

    public function chapter($chapter){
        $test = $this->test->where("chapter",$chapter)->orderBy("order","asc")->get();
        return $test;
    }
}
