<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoleDatatable;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    protected $model, $repository;

    public function __construct()
    {
        $this->model = new Role();
        $this->repository = new RoleRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleDatatable $datatable)
    {
        return $datatable->render('backend.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allRoutes = checkPermissionAccessRouteName();
        return view('backend.role.form',compact('allRoutes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $request->validated();

        $param = $request->all();

        $saveData = $this->repository->create($param);

        if (!empty($saveData)) {
            $request->session()->flash('success', 'Data Role berhasil di masukan!');
            return redirect()->route('role.index');
        } else {
            $request->session()->flash('error', 'Gagal menyimpan data Role!');
            return redirect()->route('role.index');
        }
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
        if(isOnlyDataOwned()){
            $data = $this->model->exceptSuperAdmin()
                ->where('created_by','=',user_info('id'))
                ->where('id','=',$id)
                ->firstOrFail();
        } else {
            $data = $this->model->exceptSuperAdmin()->findOrFail($id);
        }

        return view('backend.role.form',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $request->validated();

        $param = $request->all();

        $saveData = $this->repository->update($param,$id);

        if (!empty($saveData)) {
            $request->session()->flash('success', 'Data Role berhasil di update!');
            return redirect()->route('role.index');
        } else {
            $request->session()->flash('error', 'Gagal menyimpan data Role!');
            return redirect()->route('role.index');
        }
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
