<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouModuleQuestionRequest;
use App\Models\BunpouModuleQuestion;
use App\Models\BunpouModuleTest;
use App\Models\BunpouModuleAnswer;
use App\Models\BunpouModules;
use App\Repositories\BunpouModuleQuestionRepository;
use App\Repositories\BunpouModuleAnswerRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouModuleQuestionDatatable;

class BunpouModuleQuestionController extends Controller
{

    protected $question, $repoQuestion, $test, $answer, $repoAnswer, $module;

    public function __construct()
    {
        $this->question = new BunpouModuleQuestion();
        $this->test = new BunpouModuleTest();
        $this->answer = new BunpouModuleAnswer();
        $this->module = new BunpouModules();
        $this->repoQuestion = new BunpouModuleQuestionRepository();
        $this->repoAnswer = new BunpouModuleAnswerRepository();
    }

    protected $redirectAfterSave = 'bunpou.module.question.index';
    protected $moduleName = 'Bunpou Module Question';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouModuleQuestionDatatable $dataTable, $test=null)
    {
        if($test==null){
            return redirect()->route("bunpou.module.index");
        }

        if(request()->module!=null){
            $data = $this->test->data([
                ["module", "=", request()->module],
                ["is_active", "=", true],
            ])->orderBy("order","asc")->firstOrFail();
            return redirect()->route($this->redirectAfterSave,$data->id);
        }

        $data = $this->test->data($test)->firstOrFail();
        $test = $this->test->data([
            ["is_active", "=", true],
            ["module", "=", $data->module],
        ])->get();
        $modules = $this->module->withTestCount();

        return $dataTable->render('backend.bunpou.module.question.index',compact("data","test","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($test=null)
    {
        if($test==null){
            return redirect()->route("bunpou.module.index");
        }

        $test = $this->test->data($test)->firstOrFail();
        return view('backend.bunpou.module.question.form',compact("test"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouModuleQuestionRequest $request)
    {
        $test = $this->test->data($request->test)->firstOrFail();
        $param = $request->all();

        $question = $this->repoQuestion->create($param);
        if (empty($question)) {
            flashDataAfterSave($question,$this->moduleName);
            return redirect()->route($this->redirectAfterSave,$test->id);
        }

        $param["question"] = $question->id;
        $answer = $this->repoAnswer->create($param);
        if (empty($answer)) {
            $this->question->delete($question->id);
        }

        flashDataAfterSave($answer,$this->moduleName);
        return redirect()->route($this->redirectAfterSave,$test->id);

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

        $question = $this->question->data($id)->firstOrFail();
        $answers = $this->answer->data("question",$id)->orderBy("order","asc")->get();
        $test = $this->test->data($question->test)->firstOrFail();

        return view('backend.bunpou.module.question.form', compact('question','test','answers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BunpouModuleQuestionRequest $request, $id)
    {
        $test = $this->test->data($request->test)->firstOrFail();
        $param = $request->all();

        $question = $this->repoQuestion->update($param, $id);
        if (empty($question)) {
            flashDataAfterSave($question,$this->moduleName);
            return redirect()->route($this->redirectAfterSave,$test->id);
        }

        $answer = $this->repoAnswer->update($param, $id);

        flashDataAfterSave($answer,$this->moduleName);
        return redirect()->route($this->redirectAfterSave,$test->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repoAnswer->delete($id);
        return $this->repoQuestion->delete($id);
    }

    public function activate($id)
    {
        return $this->repository->activate($id);
    }

    public function deactivate($id)
    {
        return $this->repository->deactivate($id);
    }

    public function redirect(){
        $test = $this->test->isActive()->firstOrFail();
        return redirect()->route($this->redirectAfterSave,$test->id);
    }
}
