<?php

namespace App\Http\Controllers\Admin\C;

use App\DataTables\ParticleEducationDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParticleEducationRequest;
use App\Models\ParticleEducation;
use App\Models\MasterVerbLevel;
use App\Models\ParticleEducationChapter;
use App\Repositories\ParticleEducationRepository;
use Illuminate\Http\Request;

class ParticleEducationController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new ParticleEducation();
        $this->repository = new ParticleEducationRepository();
    }

    protected $redirectAfterSave = 'particle-educations.index';
    protected $moduleName = 'particle_educations';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ParticleEducationDatatable $datatable)
    {
        return $datatable->render('backend.particle.educations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $educations = ParticleEducationChapter::where('is_active', 1)->get();
        return view('backend.particle.educations.form', compact('educations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParticleEducationRequest $request)
    {
        $param = $request->all();
        $saveData = $this->repository->create($param);
        flashDataAfterSave($saveData, $this->moduleName);

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
        if (isOnlyDataOwned()) {
            $data = $this->model
                ->where('created_by', '=', user_info('id'))
                ->where('id', '=', $id)
                ->firstOrFail();
        } else {
            $data = $this->model->findOrFail($id);
        }

        $educations = ParticleEducationChapter::where('is_active', 1)->get();
        return view('backend.particle.educations.form', compact('data', 'educations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $param = $request->all();
        $saveData = $this->repository->update($param, $id);
        flashDataAfterSave($saveData, $this->moduleName);

        return redirect()->route($this->redirectAfterSave);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $this->repository->delete($id);
    // }
}
