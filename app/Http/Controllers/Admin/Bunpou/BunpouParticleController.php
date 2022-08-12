<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouParticleRequest;
use App\Models\BunpouParticle;
use App\Models\BunpouChapters;
use App\Models\BunpouModules;
use App\Models\BunpouParticleDetail;
use App\Repositories\BunpouParticleRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouParticleDatatable;

class BunpouParticleController extends Controller
{

    protected $particle, $repository, $chapter, $module, $detail;

    public function __construct()
    {
        $this->module = new BunpouModules();
        $this->particle = new BunpouParticle();
        $this->chapter = new BunpouChapters();
        $this->repository = new BunpouParticleRepository();
        $this->detail = new BunpouParticleDetail();
    }

    protected $redirectAfterSave = 'bunpou.particle.index';
    protected $moduleName = 'Bunpou Particle';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouParticleDatatable $dataTable)
    {
        $modules = $this->module->withChapterCount();
        $data = request()->module!=null
            ? $this->module->data(request()->module)->firstOrFail()
            : $modules[0];

        return $dataTable->render('backend.bunpou.particle.index',compact("data","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->module->withChapterCount();
        return view('backend.bunpou.particle.form',compact("modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouParticleRequest $request)
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
        $data = $this->particle->data($id)->firstOrFail();
        $chapter = $this->chapter->data($data->chapter)->firstOrFail();
        $modules = $this->module->withChapterCount();

        return view('backend.bunpou.particle.form',compact("data","chapter","modules"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BunpouParticleRequest $request, $id)
    {
        $this->chapter->data($request->chapter)->firstOrFail();
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
        $particle = $this->particle->data($id)->firstOrFail();
        $detail = $this->detail->data("particle",$particle->id)->first();
        if($detail!=null){
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

    public function chapter($chapter){
        $particle = $this->particle->where("chapter",$chapter)->orderBy("order","asc")->get();
        return $particle;
    }
}
