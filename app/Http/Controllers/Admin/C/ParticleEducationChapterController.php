<?php

namespace App\Http\Controllers\Admin\C;

use App\DataTables\ParticleEducationChapterDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParticleEducationChapterRequest;
use App\Models\ParticleEducationChapter;
use App\Models\MasterVerbLevel;
use App\Repositories\ParticleEducationChapterRepository;
use Illuminate\Http\Request;

class ParticleEducationChapterController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new ParticleEducationChapter();
        $this->repository = new ParticleEducationChapterRepository();
    }

    protected $redirectAfterSave = 'particle-education-chapters.index';
    protected $moduleName = 'particle_educations_chapters';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ParticleEducationChapterDatatable $datatable)
    {
        return $datatable->render('backend.particle.educations_chapters.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.particle.educations_chapters.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParticleEducationChapterRequest $request)
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

        return view('backend.particle.educations_chapters.form',compact('data'));
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
        $saveData = $this->repository->update($param,$id);
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
