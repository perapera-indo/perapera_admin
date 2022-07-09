<?php

namespace App\Http\Controllers\Admin\A;

use App\DataTables\LetterDatatable;
use App\DataTables\LetterCategoryTypeDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\LetterRequest;
use App\Models\Letter;
use App\Models\LetterCategory;
use App\Repositories\LetterCategoryRepository;
use App\Repositories\LetterRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LetterController extends Controller
{
    protected $model, $repository;
    public function __construct()
    {
        $this->model = new Letter();
        $this->repository = new LetterRepository();
    }

    protected $redirectAfterSave = 'letters.index';
    protected $redirectAfterSave1 = 'letter-hiragana-list';
    protected $redirectAfterSave2 = 'letter-katakana-list';
    protected $moduleName = 'Huruf';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LetterDatatable $datatable)
    {
        return $datatable->render('backend.letters.letters.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryindex(LetterCategoryTypeDatatable $datatable)
    {
        $route = Route::currentRouteName();
        // dd($route);
        if ($route == "letter-hiragana-list") {
            $cid = 1;
        } else {
            $cid = 2;
        }
        // dd($cid);
        return $datatable->with('cid', $cid)->render('backend.letters.new-letters.index', compact('cid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $letterCats = LetterCategory::get();
        return view('backend.letters.letters.form', compact('letterCats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newcreate()
    {
        $route = Route::currentRouteName();
        // dd($route);
        if ($route == "letter-hiragana-list") {
            $cid = 1;
        } else {
            $cid = 2;
        }
        return view('backend.letters.new-letters.form', compact('cid'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LetterRequest $request)
    {

        $param = $request->all();
        $saveData = $this->repository->createNew($param);
        flashDataAfterSave($saveData, $this->moduleName);

        return redirect()->route($this->redirectAfterSave);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function categorystore(LetterRequest $request)
    {
        // dd($request);
        $param = $request->all();
        $saveData = $this->repository->createNew($param);
        flashDataAfterSave($saveData, $this->moduleName);

        if ($param['category'] == 1) {
            return redirect()->route($this->redirectAfterSave1);
        } elseif ($param['category'] == 2) {
            return redirect()->route($this->redirectAfterSave2);
        } else {
            return redirect()->route($this->redirectAfterSave);
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
        if (isOnlyDataOwned()) {
            $data = $this->model
                ->where('created_by', '=', user_info('id'))
                ->where('id', '=', $id)
                ->firstOrFail();
        } else {
            $data = $this->model->findOrFail($id);
        }
        $letterCats = LetterCategory::get();
        return view('backend.letters.letters.form', compact('data', 'letterCats'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categoryedit($letter_category_id, $id)
    {
        if (isOnlyDataOwned()) {
            $data = $this->model
                ->where('created_by', '=', user_info('id'))
                ->where('id', '=', $id)
                ->firstOrFail();
        } else {
            $data = $this->model->findOrFail($id);
        }
        $letterCats = LetterCategory::get();
        return view('backend.letters.letters.form', compact('data', 'letterCats'));
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
        $saveData = $this->repository->updateLetter($param, $id);
        flashDataAfterSave($saveData, $this->moduleName);

        if ($param['category'] == 1) {
            return redirect()->route($this->redirectAfterSave1);
        } elseif ($param['category'] == 2) {
            return redirect()->route($this->redirectAfterSave2);
        } else {
            return redirect()->route($this->redirectAfterSave);
        }
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
