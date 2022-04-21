<?php

namespace App\Http\Controllers\Admin\E;

use App\DataTables\KanjiChapterDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterGroupRequest;
use App\Http\Requests\KanjiChapterRequest;
use App\Models\MasterGroup;
use App\Models\KanjiChapter;
use App\Repositories\KanjiChapterRepository;
use Illuminate\Http\Request;

class KanjiChapterController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new KanjiChapter();
        $this->repository = new KanjiChapterRepository();
    }

    protected $redirectAfterSave = 'kanji-chapters.index';
    protected $moduleName = 'Kanji Chapter';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanjiChapterDatatable $datatable)
    {
        return $datatable->render('backend.kanji.chapters.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = MasterGroup::where('is_active', 1)->get();
        $type = "new";
        return view('backend.kanji.chapters.form', compact('groups', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KanjiChapterRequest $request)
    {
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
        $type = "update";
        return view('backend.kanji.chapters.form', compact('data', 'groups', 'type'));
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
