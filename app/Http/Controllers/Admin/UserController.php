<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\DataTables\UserDatatable;
use Sentinel;

class UserController extends Controller
{

    protected $model, $repository;

    public function __construct()
    {
        $this->model = new User();
        $this->repository = new UserRepository();
        $this->role = new Role();
    }

    protected $redirectAfterSave = 'user.index';
    protected $moduleName = 'User';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDatatable $dataTable)
    {
        return $dataTable->render('backend.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->role->getRoles();
        return view('backend.user.form',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $param = $request->all();
        $saveData = $this->repository->createNewUser($param);
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
        $roles = $this->role->getRoles();
        if(isOnlyDataOwned()){
            $data = $this->model->getUserRole($id)
                ->where('users.created_by','=',user_info('id'))
                ->firstOrFail();
        } else {
            $data = $this->model->getUserRole($id)->firstOrFail();
        }

        return view('backend.user.form', compact('data','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $param = $request->all();
        $saveData = $this->repository->updateUser($param, $id);
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
        return $this->repository->deleteUser($id);
    }
}
