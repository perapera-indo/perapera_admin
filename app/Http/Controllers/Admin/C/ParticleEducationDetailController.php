<?php

namespace App\Http\Controllers\Admin\C;

use App\DataTables\ParticleEducationDetailDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParticleEducationDetailRequest;
use App\Models\ParticleEducation;
use App\Models\ParticleEducationDetail;
use App\Repositories\ParticleEducationDetailRepository;
use Illuminate\Http\Request;

class ParticleEducationDetailController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new ParticleEducationDetail();
        $this->repository = new ParticleEducationDetailRepository();
    }

    protected $redirectAfterSave = 'particle-education-details.index';
    protected $moduleName = 'particle_educations';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ParticleEducationDetailDatatable $datatable)
    {
        return $datatable->render('backend.particle.educations.details.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $educations = ParticleEducation::where('is_active', 1)->get();
        $type = "new";
        return view('backend.particle.educations.details.form', compact('educations','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParticleEducationDetailRequest $request)
    {
        $param = $request->all();
        $saveData = $this->repository->createNew($param);
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
        if(isOnlyDataOwned()){
            $data = $this->model
                ->where('created_by','=',user_info('id'))
                ->where('id','=',$id)
                ->firstOrFail();
        } else {
            $data = $this->model->findOrFail($id);
        }
        $educations = ParticleEducation::where('is_active', 1)->get();
        return view('backend.particle.educations.details.form',compact('data', 'educations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParticleEducationDetailRequest $request, $id)
    {
        $param = $request->all();
        $saveData = $this->repository->updateDetail($param,$id);
        flashDataAfterSave($saveData,$this->moduleName);

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
