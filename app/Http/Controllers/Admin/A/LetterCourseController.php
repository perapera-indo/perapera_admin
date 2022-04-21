<?php

namespace App\Http\Controllers\Admin\A;

use App\DataTables\LetterCourseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\LetterCourseRequest;
use App\Http\Requests\LetterRequest;
use App\Models\LetterCategory;
use App\Models\LetterCourse;
use App\Repositories\LetterCourseRepository;
use Illuminate\Http\Request;

class LetterCourseController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new LetterCourse();
        $this->repository = new LetterCourseRepository();
    }

    protected $redirectAfterSave = 'letter-courses.index';
    protected $moduleName = 'letter-courses';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LetterCourseDatatable $datatable)
    {
        return $datatable->render('backend.letters.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $letterCats = LetterCategory::where('code','!=', 'kanji')->get();
        return view('backend.letters.courses.form', compact('letterCats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LetterCourseRequest $request)
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
        $letterCats = LetterCategory::where('code','!=', 'kanji')->get();
        return view('backend.letters.courses.form', compact('data', 'letterCats'));
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
        $saveData = $this->repository->updateLetter($param, $id);
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
