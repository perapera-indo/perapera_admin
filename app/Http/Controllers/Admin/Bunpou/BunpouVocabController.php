<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouVocabRequest;
use App\Models\BunpouVocab;
use App\Models\BunpouChapters;
use App\Models\BunpouModules;
use App\Repositories\BunpouIntroRepository;
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
        $this->repository = new BunpouIntroRepository();
    }

    protected $redirectAfterSave = 'bunpou.vocabulary.index';
    protected $moduleName = 'Bunpou Vocabularies';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouVocabDatatable $dataTable, $chapter=null)
    {
        if($chapter==null){
            return redirect()->route("bunpou.chapter.redirect");
        }

        if(request()->module!=null){
            $data = $this->chapter->data([
                ["module", "=", request()->module],
                ["is_active", "=", true],
            ])->orderBy("order","asc")->firstOrFail();
            return redirect()->route($this->redirectAfterSave,$data->id);
        }

        $data = $this->chapter->data($chapter)->firstOrFail();
        $chapters = $this->chapter->data([
            ["is_active", "=", true],
            ["module", "=", $data->module],
        ])->get();
        $modules = $this->module->withChapterCount();

        return $dataTable->render('backend.bunpou.vocab.index',compact("data","modules","chapters"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($chapter=null)
    {
        if($chapter==null){
            return redirect()->route("bunpou.chapter.redirect");
        }
        $chapter = $this->chapter->data($chapter)->firstOrFail();

        return view('backend.bunpou.vocab.form',compact("chapter"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouVocabRequest $request)
    {
        $module = $this->module->data($request->module)->firstOrFail();
        $param = $request->all();
        $saveData = $this->repository->create($param);
        flashDataAfterSave($saveData,$this->moduleName);

        return redirect()->route($this->redirectAfterSave,$module->id);
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
        $data = $this->model->data()->where("id","<>",$id)->get()->pluck('room')->all();
        $rooms = $this->room->data("id","not",$data)->get();

        $data = $this->model->data($id)->firstOrFail();

        return view('backend.bunpou.intro.form',compact("rooms","data"));
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

    public function redirect(){
        $module = $this->module->isActive()->firstOrFail();
        return redirect()->route($this->redirectAfterSave,$module->id);
    }
}
