<?php
namespace App\Views;

use App\Helpers\ApiResponse;

class AuthView
{
    protected $apiResponse;
    function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    public function success_refresh_token($data){
        return $this->apiResponse->success($data);
    }
    public function error_refresh_token(){
        return $this->apiResponse->error("invalid refresh token","ERR_INVALID_REFRESH_TOKEN",401);
    }

    public function success_login($data){
        return $this->apiResponse->success($data);
    }
    
    public function error_login(){
        return $this->apiResponse->error('incorrect username or password','ERR_INVALID_CREDS',401);
    }

    
}
