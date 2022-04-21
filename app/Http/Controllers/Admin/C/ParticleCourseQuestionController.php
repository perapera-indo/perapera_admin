<?php

namespace App\Http\Controllers\Admin\C;

use App\DataTables\ParticleCourseQuestionDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParticleCourseQuestionRequest;
use App\Models\ParticleCourse;
use App\Models\ParticleCourseAnswer;
use App\Models\ParticleCourseQuestion;
use App\Repositories\ParticleCourseQuestionRepository;
use Illuminate\Http\Request;

class ParticleCourseQuestionController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new ParticleCourseQuestion();
        $this->repository = new ParticleCourseQuestionRepository();
    }

    protected $redirectAfterSave = 'particle-course-questions.index';
    protected $moduleName = 'particle-courses-questions';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ParticleCourseQuestionDatatable $datatable)
    {
        return $datatable->render('backend.particle.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $courses = ParticleCourse::where('is_active', 1)->get();

        $courses = ParticleCourse::select('particle_courses.id', 'particle_courses.title', 'particle_education_chapters.id as chp_id', 'particle_education_chapters.title as chapter_title')
            ->join('particle_education_chapters', 'particle_education_chapters.id', '=', 'particle_courses.particle_education_chapter_id')
            ->where('particle_courses.is_active', 1)
            ->groupBy('chp_id', 'particle_courses.title', 'chapter_title','particle_courses.id')
            ->get();

        $type = "new";
        return view('backend.particle.questions.form', compact('courses','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParticleCourseQuestionRequest $request)
    {
        // dd($request);
        $param = $request->all();
        $saveData = $this->repository->createNew($param);
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

        $courses = ParticleCourse::select('particle_courses.id', 'particle_courses.title', 'particle_education_chapters.id as chp_id', 'particle_education_chapters.title as chapter_title')
            ->join('particle_education_chapters', 'particle_education_chapters.id', '=', 'particle_courses.particle_education_chapter_id')
            ->where('particle_courses.is_active', 1)
            ->groupBy('chp_id', 'particle_courses.title', 'chapter_title','particle_courses.id')
            ->get();

        $answers = ParticleCourseAnswer::where('particle_course_question_id', $id)->orderBy('id','ASC')->get();
        $type = "edit";
        return view('backend.particle.questions.form', compact('data', 'courses','answers', 'type'));
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
