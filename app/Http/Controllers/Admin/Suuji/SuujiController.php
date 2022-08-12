<?php

namespace App\Http\Controllers\Admin\Suuji;

use App\Http\Requests\SuujiIntroRequest;
use App\Models\Room;
use App\Models\Suuji;
use App\Repositories\SuujiIntroRepository;
use App\Http\Controllers\Controller;
use App\DataTables\SuujiIntroDatatable;

class SuujiController extends Controller
{

    protected $model, $repository, $room;

    public function __construct()
    {
        $this->model = new Suuji();
        $this->room = new Room();
        $this->repository = new SuujiIntroRepository();
    }

    protected $redirectAfterSave = 'suuji.intro.index';
    protected $moduleName = 'Suuji Introduction';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SuujiIntroDatatable $dataTable)
    {
        return $dataTable->render('backend.suuji.intro.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->model->data()->get()->pluck('room')->all();

        $rooms = $this->room->data("id","not",$data)->get();

        return view('backend.suuji.intro.form',compact("rooms"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuujiIntroRequest $request)
    {
        $param = $request->all();
        $saveData = $this->repository->create($param);
        flashDataAfterSave($saveData,$this->moduleName);

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
        $data = $this->model->data()->where("id","<>",$id)->get()->pluck('room')->all();
        $rooms = $this->room->data("id","not",$data)->get();

        $data = $this->model->data($id)->firstOrFail();

        return view('backend.suuji.intro.form',compact("rooms","data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuujiIntroRequest $request, $id)
    {
        $param = $request->all();
        $saveData = $this->repository->update($id,$param);
        flashDataAfterSave($saveData,$this->moduleName);

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
        return $this->repository->delete($id);
    }
}
