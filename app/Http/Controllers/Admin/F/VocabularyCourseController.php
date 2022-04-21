<?php

namespace App\Http\Controllers\Admin\F;

use App\DataTables\VocabularyCourseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\VocabularyCourseRequest;
use App\Models\VocabularyCourse;
use App\Models\VocabularyCourseChapter;
use App\Repositories\VocabularyCourseRepository;
use Illuminate\Http\Request;

class VocabularyCourseController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new VocabularyCourse();
        $this->repository = new VocabularyCourseRepository();
    }

    protected $redirectAfterSave = 'vocabulary-courses.index';
    protected $moduleName = 'vocabulary courses';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VocabularyCourseDatatable $datatable)
    {
        return $datatable->render('backend.vocabulary.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapters = VocabularyCourseChapter::where('is_active', 1)->get();
        return view('backend.vocabulary.courses.form', compact('chapters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VocabularyCourseRequest $request)
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

        $chapters = VocabularyCourseChapter::where('is_active', 1)->get();
        return view('backend.vocabulary.courses.form', compact('data','chapters'));
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
