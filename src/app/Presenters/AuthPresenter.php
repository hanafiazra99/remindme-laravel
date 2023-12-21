<?php

namespace App\Presenters;

use App\Views\AuthView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthPresenter
{

    protected $view;
    public function __construct(AuthView $view) {
        $this->view = $view;
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->view->error_login();
        }
        $user = Auth::user('api');
        $refresh_token = JWTAuth::fromUser($user);
        $res['user'] = $user;
        $res['token'] = $token;
        $res['refresh_token'] = $refresh_token;
        return $this->view->success_login($res);
        
    }


    public function refresh_token()
    {
        try {
            $new_token = JWTAuth::parseToken()->refresh();
            return $this->view->success_refresh_token(['access_token'=>$new_token]);
        } catch (JWTException $e) {
            return $this->view->error_refresh_token();
        }
    }
}
