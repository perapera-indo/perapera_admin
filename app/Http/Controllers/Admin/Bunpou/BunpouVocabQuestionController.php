<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouVocabQuestionRequest;
use App\Models\BunpouVocabQuestion;
use App\Models\BunpouVocabTest;
use App\Models\BunpouVocabAnswer;
use App\Models\BunpouModules;
use App\Models\BunpouChapters;
use App\Models\BunpouVocabResult;
use App\Repositories\BunpouVocabQuestionRepository;
use App\Repositories\BunpouVocabAnswerRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouVocabQuestionDatatable;

class BunpouVocabQuestionController extends Controller
{

    protected $question, $repoQuestion, $test, $answer, $repoAnswer, $module, $result, $chapter;

    public function __construct()
    {
        $this->result = new BunpouVocabResult();
        $this->module = new BunpouModules();
        $this->question = new BunpouVocabQuestion();
        $this->test = new BunpouVocabTest();
        $this->repoQuestion = new BunpouVocabQuestionRepository();
        $this->repoAnswer = new BunpouVocabAnswerRepository();
        $this->answer = new BunpouVocabAnswer();
        $this->chapter = new BunpouChapters();
    }

    protected $redirectAfterSave = 'bunpou.vocabulary.question.index';
    protected $moduleName = 'Bunpou Vocabulary Question';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouVocabQuestionDatatable $dataTable)
    {
        $modules = $this->module->withChapterCount();
        $data = request()->module!=null
            ? $this->module->data(request()->module)->firstOrFail()
            : $modules[0];
        return $dataTable->render('backend.bunpou.vocab.question.index',compact("data","modules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->module->withChapterCount();
        return view('backend.bunpou.vocab.question.form',compact("modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouVocabQuestionRequest $request)
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

        return view('backend.bunpou.vocab.question.form', compact('question','test','answers','modules','chapter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BunpouVocabQuestionRequest $request, $id)
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
