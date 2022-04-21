<?php

namespace App\Http\Controllers\Admin\G;

use App\DataTables\AbilityCourseChapterDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AbilityCourseChapterRequest;
use App\Models\AbilityCourseChapter;
use App\Models\MasterAbilityCourseChapter;
use App\Models\MasterAbilityCourseChapterLevel;
use App\Models\MasterGroup;
use App\Repositories\AbilityCourseChapterRepository;
use Illuminate\Http\Request;

class AbilityCourseChapterController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new AbilityCourseChapter();
        $this->repository = new AbilityCourseChapterRepository();
    }

    protected $redirectAfterSave = 'ability-course-chapters.index';
    protected $moduleName = 'ability courses chapter';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AbilityCourseChapterDatatable $datatable)
    {
        return $datatable->render('backend.ability.chapters.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = MasterGroup::where('is_active', 1)->get();
        return view('backend.ability.chapters.form', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbilityCourseChapterRequest $request)
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

        $groups = MasterGroup::where('is_active', 1)->get();

        return view('backend.ability.chapters.form', compact('data', 'groups'));
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
