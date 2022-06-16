<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouModuleQuestionRequest;
use App\Models\BunpouModuleQuestion;
use App\Models\BunpouModuleTest;
use App\Models\BunpouModuleAnswer;
use App\Models\BunpouModules;
use App\Models\BunpouModuleResult;
use App\Repositories\BunpouModuleQuestionRepository;
use App\Repositories\BunpouModuleAnswerRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouModuleQuestionDatatable;

class BunpouModuleQuestionController extends Controller
{

    protected $question, $repoQuestion, $test, $answer, $repoAnswer, $module, $result;

    public function __construct()
    {
        $this->question = new BunpouModuleQuestion();
        $this->test = new BunpouModuleTest();
        $this->answer = new BunpouModuleAnswer();
        $this->module = new BunpouModules();
        $this->result = new BunpouModuleResult();
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
    public function index(BunpouModuleQuestionDatatable $dataTable)
    {
        $modules = $this->module->withTestCount();
        $data = request()->module!=null
            ? $this->module->data(request()->module)->firstOrFail()
            : $modules[0];
        return $dataTable->render('backend.bunpou.module.question.index',compact("data","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->module->withTestCount();
        return view('backend.bunpou.module.question.form',compact("modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouModuleQuestionRequest $request)
    {
        $this->test->data($request->test)->firstOrFail();
        $param = $request->all();

        $question = $this->repoQuestion->create($param);
        if (empty($question)) {
            flashDataAfterSave($question,$this->moduleName);
            return redirect()->route($this->redirectAfterSave);
        }

        $param["question"] = $question->id;
        $answer = $this->repoAnswer->create($param);
        if (empty($answer)) {
            $this->question->delete($question->id);
        }

        flashDataAfterSave($answer,$this->moduleName);
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
        $question = $this->question->data($id)->firstOrFail();
        $answers = $this->answer->data("question",$id)->orderBy("order","asc")->get();
        $test = $this->test->data($question->test)->firstOrFail();
        $modules = $this->module->withTestCount();

        return view('backend.bunpou.module.question.form', compact('question','test','answers','modules'));
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
        $this->test->data($request->test)->firstOrFail();
        $param = $request->all();

        $question = $this->repoQuestion->update($param, $id);
        if (empty($question)) {
            flashDataAfterSave($question,$this->moduleName);
            return redirect()->route($this->redirectAfterSave);
        }

        $answer = $this->repoAnswer->update($param, $id);

        flashDataAfterSave($answer,$this->moduleName);
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
        $question = $this->question->data($id)->firstOrFail();

        $result = $this->result->data("test",$question->test)->first();
        if($result!=null){
            return "false";
        }

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
}
