<?php

namespace App\Http\Controllers\Admin\B;

use App\DataTables\VerbChangeDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterVerbWordRequest;
use App\Http\Requests\VerbChangeRequest;
use App\Models\MasterVerbWord;
use App\Models\VerbChange;
use App\Repositories\VerbChangeRepository;
use Illuminate\Http\Request;

class VerbChangeController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new VerbChange();
        $this->repository = new VerbChangeRepository();
    }

    protected $redirectAfterSave = 'verb-changes.index';
    protected $moduleName = 'verb_changes';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VerbChangeDatatable $datatable)
    {
        return $datatable->render('backend.verbs.changes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $words = MasterVerbWord::where('is_active', 1)->get();
        return view('backend.verbs.changes.form', compact('words'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VerbChangeRequest $request)
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
        $words = MasterVerbWord::where('is_active', 1)->get();
        return view('backend.verbs.changes.form',compact('data','words'));
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
