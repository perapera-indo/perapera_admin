<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Repositories\RoomRepository;
use App\Http\Controllers\Controller;
use App\DataTables\RoomDatatable;

class RoomController extends Controller
{

    protected $model, $repository;

    public function __construct()
    {
        $this->model = new Room();
        $this->repository = new RoomRepository();
    }

    protected $redirectAfterSave = 'room.index';
    protected $moduleName = 'Room';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoomDatatable $dataTable)
    {
        return $dataTable->render('backend.room.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.room.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
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
        $data = $this->model->data($id)->firstOrFail();

        // is image or video
        $fn = $data->path;
        $mime = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($mime,$fn);
        $mimetype = substr($mimetype, 0, strpos($mimetype, ';'));
        $type = explode("/",$mimetype)[0];
        finfo_close($mime);

        return view('backend.room.show', compact('data','type','mimetype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = $this->model->data($id)->firstOrFail();

        return view('backend.room.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, $id)
    {
        $param = $request->all();
        $saveData = $this->repository->update($param, $id);
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
