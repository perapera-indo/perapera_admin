<?php

namespace App\Http\Controllers\Admin\B;

use App\DataTables\MasterVerbWordDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterVerbWordRequest;
use App\Models\MasterVerbGroup;
use App\Models\MasterVerbWord;
use App\Repositories\MasterVerbWordRepository;
use Illuminate\Http\Request;

class MasterVerbWordController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new MasterVerbWord();
        $this->repository = new MasterVerbWordRepository();
    }

    protected $redirectAfterSave = 'verb-words.index';
    protected $moduleName = 'verb_groups';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MasterVerbWordDatatable $datatable)
    {
        return $datatable->render('backend.verbs.words.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = MasterVerbGroup::where('is_active', 1)->get();
        return view('backend.verbs.words.form', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterVerbWordRequest $request)
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
        if(isOnlyDataOwned()){
            $data = $this->model
                ->where('created_by','=',user_info('id'))
                ->where('id','=',$id)
                ->firstOrFail();
        } else {
            $data = $this->model->findOrFail($id);
        }
        $groups = MasterVerbGroup::where('is_active', 1)->get();
        return view('backend.verbs.words.form',compact('data','groups'));
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
