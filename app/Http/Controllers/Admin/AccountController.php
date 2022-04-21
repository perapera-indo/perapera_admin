<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChangePasswordRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    protected $repository;
    public function __construct()
    {
    	$this->repository = new UserRepository();
    }

    protected $redirectAfterSave = 'dashboard';
    protected $moduleName = 'User';

    public function changePassword()
    {
        return view('backend.account.form');
    }

    public function postChangePassword(ChangePasswordRequest $request)
    {
        $param = $request->all();
        $user = $this->repository->changePassword($param);
        flashDataAfterSave($user,$this->moduleName);

        return redirect()->route($this->redirectAfterSave);
    }
}
