<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouParticleDetailRequest;
use App\Models\BunpouModules;
use App\Models\BunpouChapters;
use App\Models\BunpouParticle;
use App\Models\BunpouParticleDetail;
use App\Repositories\BunpouParticleDetailRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouParticleDetailDatatable;

class BunpouParticleDetailController extends Controller
{

    protected $module, $chapter, $particle, $repository, $detail;

    public function __construct()
    {
        $this->module = new BunpouModules();
        $this->particle = new BunpouParticle();
        $this->repository = new BunpouParticleDetailRepository();
        $this->detail = new BunpouParticleDetail();
        $this->chapter = new BunpouChapters();
    }

    protected $redirectAfterSave = 'bunpou.particle.detail.index';
    protected $moduleName = 'Bunpou Particle Detail';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouParticleDetailDatatable $dataTable)
    {
        $modules = $this->module->withChapterCount();
        $data = request()->module!=null
            ? $this->module->data(request()->module)->firstOrFail()
            : $modules[0];
        return $dataTable->render('backend.bunpou.particle.detail.index',compact("data","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->module->withChapterCount();
        return view('backend.bunpou.particle.detail.form',compact("modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouParticleDetailRequest $request)
    {
        $this->particle->data($request->particle)->firstOrFail();
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
        $data = $this->detail->data($id)->firstOrFail();
        $particle = $this->particle->data($data->particle)->firstOrFail();
        $chapter = $this->chapter->data($particle->chapter)->firstOrFail();
        return view('backend.bunpou.particle.detail.form',compact("modules","particle","chapter","data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BunpouParticleDetailRequest $request, $id)
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
}
