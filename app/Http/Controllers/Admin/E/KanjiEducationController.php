<?php

namespace App\Http\Controllers\Admin\E;

use App\DataTables\KanjiEducationDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\KanjiChapterRequest;
use App\Http\Requests\KanjiEducationRequest;
use App\Models\KanjiChapter;
use App\Models\KanjiEducation;
use App\Repositories\KanjiEducationRepository;
use Illuminate\Http\Request;

class KanjiEducationController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new KanjiEducation();
        $this->repository = new KanjiEducationRepository();
    }

    protected $redirectAfterSave = 'kanji-educations.index';
    protected $moduleName = 'Kanji Education';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanjiEducationDatatable $datatable)
    {
        return $datatable->render('backend.kanji.educations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapters = KanjiChapter::get();
        $type = "new";
        return view('backend.kanji.educations.form', compact('chapters', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KanjiEducationRequest $request)
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
        $chapters = KanjiChapter::get();
        $type = "update";
        return view('backend.kanji.educations.form', compact('data', 'chapters', 'type'));
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
