<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouVocabRequest;
use App\Models\BunpouVocab;
use App\Models\BunpouChapters;
use App\Models\BunpouModules;
use App\Repositories\BunpouVocabRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouVocabDatatable;

class BunpouVocabController extends Controller
{

    protected $vocab, $repository, $chapter, $module;

    public function __construct()
    {
        $this->module = new BunpouModules();
        $this->vocab = new BunpouVocab();
        $this->chapter = new BunpouChapters();
        $this->repository = new BunpouVocabRepository();
    }

    protected $redirectAfterSave = 'bunpou.vocabulary.index';
    protected $moduleName = 'Bunpou Vocabularies';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouVocabDatatable $dataTable)
    {
        $modules = $this->module->withChapterCount();
        $data = request()->module!=null
            ? $this->module->data(request()->module)->firstOrFail()
            : $modules[0];

        return $dataTable->render('backend.bunpou.vocab.index',compact("data","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->module->withChapterCount();
        return view('backend.bunpou.vocab.form',compact("modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouVocabRequest $request)
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
        $data = $this->vocab->data($id)->firstOrFail();
        $chapter = $this->chapter->data($data->chapter)->firstOrFail();
        $modules = $this->module->withChapterCount();

        return view('backend.bunpou.vocab.form',compact("data","chapter","modules"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BunpouVocabRequest $request, $id)
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
