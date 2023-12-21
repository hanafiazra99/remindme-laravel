<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReminderRequest;
use App\Presenters\ReminderPresenter;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    
    protected $presenter;
    public function __construct(ReminderPresenter $presenter) {
        $this->presenter = $presenter;
    }

    public function index(){
        return $this->presenter->fetch_all();
    }

    public function show($reminder){
        return $this->presenter->fetch_one($reminder);
    }

    public function store(ReminderRequest $request){
        return $this->presenter->store($request);
    }

    public function update(ReminderRequest $request,$reminder){
        return $this->presenter->update($request,$reminder);
    }

    public function destroy($reminder){
        return $this->presenter->destroy($reminder);
    }
}
