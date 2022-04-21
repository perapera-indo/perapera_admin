<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PermissionDatatable;
use App\Http\Requests\PermissionRequest;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new Role();
        $this->repository = new RoleRepository();
    }

    protected $redirectAfterSave = 'permission.index';
    protected $moduleName = 'Permission';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PermissionDatatable $datatable)
    {
        return $datatable->render('backend.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Request $request,$id)
    {
        $routeMiddleware = null;
        $method = null;
        $type = 'basic';
        if($request->has('type') && $request->input('type') == 'advance'){
            $routeMiddleware = 'sentinelAuth';
            $method = 'all';
            $type = 'advance';
        }

        $role = $data = Role::exceptSuperAdmin()
            ->where('id','=',$id)
            ->firstOrFail();

        $permissionList = (array)json_decode($role->permissions);
        if(!$type || $type == 'basic'){
            $allRoutes = checkPermissionAccessRouteName();
        }elseif ($type == 'advance'){
            $allRoutes = checkPermissionAccessRouteName($routeMiddleware,$method);
        }else{
            $allRoutes = checkPermissionAccessRouteName();
        }

        $sortAllRoutes = $allRoutes;
        uasort($sortAllRoutes, function($a, $b) {
            return sizeof($b) <=> sizeof($a);
        });

        $max = count(array_shift($sortAllRoutes));
        return view('backend.permission.form',compact('allRoutes','permissionList','max','role','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {dd($id);
        $param = $request->all();
        $saveData = $this->repository->updatePermission($param,$id);
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
        //
    }
}
