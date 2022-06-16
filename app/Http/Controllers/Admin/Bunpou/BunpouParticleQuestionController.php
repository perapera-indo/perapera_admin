<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouParticleQuestionRequest;
use App\Models\BunpouParticleQuestion;
use App\Models\BunpouParticleTest;
use App\Models\BunpouParticleAnswer;
use App\Models\BunpouModules;
use App\Models\BunpouChapters;
use App\Models\BunpouParticleResult;
use App\Repositories\BunpouParticleQuestionRepository;
use App\Repositories\BunpouParticleAnswerRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouParticleQuestionDatatable;

class BunpouParticleQuestionController extends Controller
{

    protected $question, $repoQuestion, $test, $answer, $repoAnswer, $module, $result, $chapter;

    public function __construct()
    {
        $this->result = new BunpouParticleResult();
        $this->module = new BunpouModules();
        $this->question = new BunpouParticleQuestion();
        $this->test = new BunpouParticleTest();
        $this->repoQuestion = new BunpouParticleQuestionRepository();
        $this->repoAnswer = new BunpouParticleAnswerRepository();
        $this->answer = new BunpouParticleAnswer();
        $this->chapter = new BunpouChapters();
    }

    protected $redirectAfterSave = 'bunpou.particle.question.index';
    protected $moduleName = 'Bunpou Particle Question';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouParticleQuestionDatatable $dataTable)
    {
        $modules = $this->module->withChapterCount();
        $data = request()->module!=null
            ? $this->module->data(request()->module)->firstOrFail()
            : $modules[0];
        return $dataTable->render('backend.bunpou.particle.question.index',compact("data","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->module->withChapterCount();
        return view('backend.bunpou.particle.question.form',compact("modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouParticleQuestionRequest $request)
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
        $chapter = $this->chapter->data($test->chapter)->firstOrFail();
        $modules = $this->module->withChapterCount();

        return view('backend.bunpou.particle.question.form', compact('question','test','answers','modules','chapter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BunpouParticleQuestionRequest $request, $id)
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
