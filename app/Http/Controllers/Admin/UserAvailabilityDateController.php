<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserAvailabilityDatatable;
use App\Models\UserAvailabilityDate;
use App\Repositories\UserAvailabilityDateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAvailabilityDateController extends Controller
{
    protected $model, $repository;
    protected $redirectAfterSave;
    public function __construct()
    {
        $this->model = new UserAvailabilityDate();
        $this->repository = new UserAvailabilityDateRepository();
    }

    protected $moduleName = 'user availability date';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(UserAvailabilityDatatable $datatable)
    {
        return $datatable->render('backend.user_available_date.index_list');
    }

    public function canCreateNew()
    {
        $canCreate = false;
        if(isRoleIn('reviewer') || isRoleIn('translator')){
            $canCreate = true;
        }

        return $canCreate;
    }

    public function indexTranslator(Request $request)
    {
        $userId = $request->input('user_id');
        $role = 'translator';
        $canCreateNew = $this->canCreateNew();
        $calendar = $this->repository->userAvailableByRole('translator',$userId);
        return view('backend.user_available_date.index', compact('calendar','role','canCreateNew'));
    }

    public function indexReviewer(Request $request)
    {
        $userId = $request->input('user_id');
        $role = 'reviewer';
        $canCreateNew = $this->canCreateNew();
        $calendar = $this->repository->userAvailableByRole('reviewer',$userId);
        return view('backend.user_available_date.index', compact('calendar','role','canCreateNew'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = user_info()->roles()->first()->slug;
        return view('backend.user_available_date.form',compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $param = $request->all();
        $saveData = $this->repository->create($param);
        flashDataAfterSave($saveData,$this->moduleName);

        $redirect = user_info()->roles()->first()->slug.'.availability.index';
        return redirect()->route($redirect);
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
            $data = $this->model
                ->where('created_by','=',user_info('id'))
                ->where('id','=',$id)
                ->firstOrFail();
        } else {
            $data = $this->model->findOrFail($id);
        }
        $role = user_info()->roles()->first()->slug;
        return view('backend.user_available_date.form',compact('data','role'));
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
        $saveData = $this->repository->update($param,$id);
        flashDataAfterSave($saveData,$this->moduleName);

        $redirect = user_info()->roles()->first()->slug.'.availability.index';
        return redirect()->route($redirect);
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
