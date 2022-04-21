<?php

namespace App\Http\Controllers\Admin\E;

use App\DataTables\KanjiMiniCourseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\KanjiMiniCourseRequest;
use App\Models\KanjiChapter;
use App\Models\KanjiMiniCourse;
use App\Repositories\KanjiMiniCourseRepository;
use Illuminate\Http\Request;

class KanjiMiniCourseController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new KanjiMiniCourse();
        $this->repository = new KanjiMiniCourseRepository();
    }

    protected $redirectAfterSave = 'kanji-mini-courses.index';
    protected $moduleName = 'Kanji Mini Courses';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanjiMiniCourseDatatable $datatable)
    {
        return $datatable->render('backend.kanji.mini.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapters = KanjiChapter::get();
        return view('backend.kanji.mini.courses.form', compact('chapters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KanjiMiniCourseRequest $request)
    {
        // dd($request);
        $param = $request->all();
        $saveData = $this->repository->create($param);
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
        $chapters = KanjiChapter::get();
        return view('backend.kanji.mini.courses.form', compact('data','chapters'));
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
