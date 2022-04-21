<?php

namespace App\Http\Controllers\Admin\F;

use App\DataTables\VocabularyDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\VocabularyRequest;
use App\Models\VocabularyChapter;
use App\Models\Vocabulary;
use App\Repositories\VocabularyRepository;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new Vocabulary();
        $this->repository = new VocabularyRepository();
    }

    protected $redirectAfterSave = 'vocabularies.index';
    protected $moduleName = 'Vocabularies / Kosa Kata';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VocabularyDatatable $datatable)
    {
        return $datatable->render('backend.vocabulary.vocabularies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapters = VocabularyChapter::where('is_active', 1)->get();
        return view('backend.vocabulary.vocabularies.form', compact('chapters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VocabularyRequest $request)
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
        $chapters = VocabularyChapter::where('is_active', 1)->get();
        return view('backend.vocabulary.vocabularies.form',compact('data','chapters'));
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
