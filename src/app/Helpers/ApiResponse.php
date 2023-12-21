<?php
namespace App\Helpers;
class ApiResponse{

    
    public function success($data=null,$code=200){
        $res = [
            'success'=>true,
        ];
        if($data != null){
            $res['data'] = $data;
        }
        return response()->json($res,$code);
    }

    public function error($message=null,$err=null,$code=500){
        
        $res = [
            'success'=>false,
            'err'=>$err,
            'message'=>$message
        ];
        return response()->json($res,$code);
    }
}