<?php

namespace App\Http\Controllers\Admin\E;

use App\DataTables\KanjiSampleDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\KanjiSampleRequest;
use App\Models\KanjiEducation;
use App\Models\KanjiSample;
use App\Repositories\KanjiSampleRepository;
use Illuminate\Http\Request;

class KanjiSampleController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new KanjiSample();
        $this->repository = new KanjiSampleRepository();
    }

    protected $redirectAfterSave = 'kanji-samples.index';
    protected $moduleName = 'Kanji Sample';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanjiSampleDatatable $datatable)
    {
        return $datatable->render('backend.kanji.samples.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $educations = KanjiEducation::where('is_active', 1)->get();
        $type = "new";
        return view('backend.kanji.samples.form', compact('educations', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KanjiSampleRequest $request)
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
        $educations = KanjiEducation::where('is_active', 1)->get();
        $type = "update";
        return view('backend.kanji.samples.form', compact('data', 'educations', 'type'));
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
