<?php

namespace App\Http\Controllers\Admin\C;

use App\DataTables\ParticleMiniCourseQuestionDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParticleMiniCourseQuestionRequest;
use App\Models\ParticleMiniCourse;
use App\Models\ParticleMiniCourseAnswer;
use App\Models\ParticleMiniCourseQuestion;
use App\Repositories\ParticleMiniCourseQuestionRepository;
use Illuminate\Http\Request;

class ParticleMiniCourseQuestionController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new ParticleMiniCourseQuestion();
        $this->repository = new ParticleMiniCourseQuestionRepository();
    }

    protected $redirectAfterSave = 'particle-mini-course-questions.index';
    protected $moduleName = 'Particle Mini Courses Questions';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ParticleMiniCourseQuestionDatatable $datatable)
    {
        return $datatable->render('backend.particle.mini.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $courses = ParticleMiniCourse::where('is_active', 1)->get();
        $courses = ParticleMiniCourse::select('particle_mini_courses.id', 'particle_mini_courses.title', 'particle_education_chapters.id as chp_id', 'particle_education_chapters.title as chapter_title')
            ->join('particle_education_chapters', 'particle_education_chapters.id', '=', 'particle_mini_courses.particle_education_chapter_id')
            ->where('particle_mini_courses.is_active', 1)
            ->groupBy('chp_id', 'particle_mini_courses.title', 'chapter_title','particle_mini_courses.id')
            ->get();

        $type = "new";
        return view('backend.particle.mini.questions.form', compact('courses','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParticleMiniCourseQuestionRequest $request)
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

        $courses = ParticleMiniCourse::select('particle_mini_courses.id', 'particle_mini_courses.title', 'particle_education_chapters.id as chp_id', 'particle_education_chapters.title as chapter_title')
            ->join('particle_education_chapters', 'particle_education_chapters.id', '=', 'particle_mini_courses.particle_education_chapter_id')
            ->where('particle_mini_courses.is_active', 1)
            ->groupBy('chp_id', 'particle_mini_courses.title', 'chapter_title','particle_mini_courses.id')
            ->get();

        $answers = ParticleMiniCourseAnswer::where('particle_mini_course_question_id', $id)->orderBy('id','ASC')->get();
        $type = "edit";

        return view('backend.particle.mini.questions.form', compact('data', 'courses','answers', 'type'));
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
