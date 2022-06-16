<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouVocabTestRequest;
use App\Models\BunpouChapters;
use App\Models\BunpouModules;
use App\Models\BunpouVocabTest;
use App\Models\BunpouVocabQuestion;
use App\Repositories\BunpouVocabTestRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouVocabTestDatatable;

class BunpouVocabTestController extends Controller
{

    protected $module, $repository, $chapter, $test;

    public function __construct()
    {
        $this->test = new BunpouVocabTest();
        $this->module = new BunpouModules();
        $this->chapter = new BunpouChapters();
        $this->question = new BunpouVocabQuestion();
        $this->repository = new BunpouVocabTestRepository();
    }

    protected $redirectAfterSave = 'bunpou.vocabulary.test.index';
    protected $moduleName = 'Bunpou Chapter Test';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouVocabTestDatatable $dataTable)
    {
        $modules = $this->module->withChapterCount();
        $data = request()->module!=null
            ? $this->module->data(request()->module)->firstOrFail()
            : $modules[0];
        return $dataTable->render('backend.bunpou.vocab.test.index',compact("data","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->module->withChapterCount();
        return view('backend.bunpou.vocab.test.form',compact("modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouVocabTestRequest $request)
    {
        $this->chapter->data($request->chapter)->firstOrFail();
        $param = $request->all();

        $data = $this->repository->create($param);

        flashDataAfterSave($data,$this->moduleName);
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
        $data = $this->test->data($id)->firstOrFail();
        $modules = $this->module->withChapterCount();
        $chapter = $this->chapter->data($data->chapter)->firstOrFail();

        return view('backend.bunpou.vocab.test.form', compact('data','modules','chapter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BunpouVocabTestRequest $request, $id)
    {
        $this->chapter->data($request->chapter)->firstOrFail();
        $param = $request->all();

        $data = $this->repository->update($param,$id);

        flashDataAfterSave($data,$this->moduleName);
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
        $question = $this->question->data("test",$id)->first();
        if($question!=null){
            return "false";
        }

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

    public function chapter($chapter){
        $test = $this->test->where("chapter",$chapter)->orderBy("order","asc")->get();
        return $test;
    }
}
