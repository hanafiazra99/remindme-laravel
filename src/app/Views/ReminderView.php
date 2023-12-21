<?php
namespace App\Views;

use App\Helpers\ApiResponse;
use App\Models\Reminder;

class ReminderView{

    protected $apiResponse;
    function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    public function success_fetch_all($data){
        
        return $this->apiResponse->success($data);
    }

    public function success_fetch_one($data){
        return $this->apiResponse->success($data);
    }

    public function success_store($data){
        return $this->apiResponse->success($data);
    }
    public function success_update($data){
        return $this->apiResponse->success($data);
    }
    public function success_destroy(){
        return $this->apiResponse->success();
    }
    
}