<?php

namespace App\Http\Controllers\Admin\Bunpou;

use App\Http\Requests\BunpouIntroRequest;
use App\Models\Room;
use App\Models\Bunpou;
use App\Repositories\BunpouIntroRepository;
use App\Http\Controllers\Controller;
use App\DataTables\BunpouIntroDatatable;

class BunpouController extends Controller
{

    protected $model, $repository, $room;

    public function __construct()
    {
        $this->model = new Bunpou();
        $this->room = new Room();
        $this->repository = new BunpouIntroRepository();
    }

    protected $redirectAfterSave = 'bunpou.intro.index';
    protected $moduleName = 'Bunpou Introduction';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BunpouIntroDatatable $dataTable)
    {
        return $dataTable->render('backend.bunpou.intro.index');
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

        return view('backend.bunpou.intro.form',compact("rooms"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunpouIntroRequest $request)
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

        return view('backend.bunpou.intro.form',compact("rooms","data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BunpouIntroRequest $request, $id)
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
        $this->repository->delete($id);
    }
}
