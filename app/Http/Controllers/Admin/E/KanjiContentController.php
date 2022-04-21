<?php

namespace App\Http\Controllers\Admin\E;

use App\DataTables\KanjiContentDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterGroupRequest;
use App\Http\Requests\KanjiContentRequest;
use App\Models\KanjiChapter;
use App\Models\MasterGroup;
use App\Models\KanjiContent;
use App\Repositories\KanjiContentRepository;
use Illuminate\Http\Request;

class KanjiContentController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new KanjiContent();
        $this->repository = new KanjiContentRepository();
    }

    protected $redirectAfterSave = 'kanji-contents-index';
    protected $moduleName = 'Kanji Content';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanjiContentDatatable $datatable, $did)
    {
        return $datatable->with('id', $did)->render('backend.kanji.contents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapters = KanjiChapter::get();
        $type = "new";
        return view('backend.kanji.contents.form', compact('chapters', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KanjiContentRequest $request, $id)
    {
        $param = $request->all();
        // dd($param);
        $saveData = $this->repository->create($param);
        flashDataAfterSave($saveData, $this->moduleName);

        return redirect()->route($this->redirectAfterSave, $id);
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
    public function edit($id, $did)
    {
        if (isOnlyDataOwned()) {
            $data = $this->model
                ->where('created_by', '=', user_info('id'))
                ->where('id', '=', $id)
                ->firstOrFail();
        } else {
            $data = $this->model->findOrFail($did);
        }
        $chapters = KanjiChapter::get();
        $type = "update";
        return view('backend.kanji.contents.form', compact('data', 'chapters', 'type'));
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

        return redirect()->route($this->redirectAfterSave, $id);
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
