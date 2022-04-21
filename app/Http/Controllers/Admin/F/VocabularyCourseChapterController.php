<?php

namespace App\Http\Controllers\Admin\F;

use App\DataTables\VocabularyCourseChapterDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\VocabularyCourseChapterRequest;
use App\Models\VocabularyCourseChapter;
use App\Repositories\VocabularyCourseChapterRepository;
use Illuminate\Http\Request;

class VocabularyCourseChapterController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new VocabularyCourseChapter();
        $this->repository = new VocabularyCourseChapterRepository();
    }

    protected $redirectAfterSave = 'vocabulary-course-chapters.index';
    protected $moduleName = 'vocabulary courses Chapter';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VocabularyCourseChapterDatatable $datatable)
    {
        return $datatable->render('backend.vocabulary.courses_chapters.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.vocabulary.courses_chapters.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VocabularyCourseChapterRequest $request)
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

        return view('backend.vocabulary.courses_chapters.form', compact('data'));
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
