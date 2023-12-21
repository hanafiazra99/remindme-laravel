<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Presenters\AuthPresenter;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $presenter;
    public function __construct(AuthPresenter $presenter) {
        $this->presenter = $presenter;
    }
    public function login(LoginRequest $request){
        
        return $this->presenter->login($request);
        
    }
    public function refresh_token(){
        return $this->presenter->refresh_token();
    }
}
