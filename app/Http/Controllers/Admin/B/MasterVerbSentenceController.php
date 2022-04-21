<?php

namespace App\Http\Controllers\Admin\B;

use App\DataTables\MasterVerbSentenceDatatable;
use App\DataTables\VerbChangeDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterVerbSentenceRequest;
use App\Http\Requests\VerbChangeRequest;
use App\Models\MasterVerbSentence;
use App\Models\MasterVerbWord;
use App\Models\VerbChange;
use App\Repositories\MasterVerbSentenceRepository;
use App\Repositories\VerbChangeRepository;
use Illuminate\Http\Request;

class MasterVerbSentenceController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new MasterVerbSentence();
        $this->repository = new MasterVerbSentenceRepository();
    }

    protected $redirectAfterSave = 'verb-sentences.index';
    protected $moduleName = 'verb_sentences';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MasterVerbSentenceDatatable $datatable)
    {
        return $datatable->render('backend.verbs.sentences.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $changes = VerbChange::where('is_active', 1)->get();
        return view('backend.verbs.sentences.form', compact('changes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterVerbSentenceRequest $request)
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
        $changes = VerbChange::where('is_active', 1)->get();
        return view('backend.verbs.sentences.form',compact('data','changes'));
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
