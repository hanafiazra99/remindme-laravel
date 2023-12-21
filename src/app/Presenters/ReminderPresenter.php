<?php

namespace App\Presenters;

use App\Http\Requests\ReminderRequest;
use App\Jobs\SendReminderJob;
use App\Models\Reminder;
use App\Views\ReminderView;
use Illuminate\Support\Facades\DB;

class ReminderPresenter{
    protected $view;
    public function __construct(ReminderView $view) {
        $this->view = $view;
    }
    
    public function fetch_all(){
        
        $count = request('limit') ?? 5;
        $offset = 0;
        $current_page = 1;
        $page_request = request('page');
        if(!empty($page_request)){
            $current_page = $page_request;
        }
        $offset = ($current_page-1)*$count;
        
        $data['reminders'] = Reminder::select('id','title','description','remind_at','event_at')->where('user_id',auth('api')->user()->id)->where('schedule_id','!=',0)->skip($offset)->take($count)->get();
        $data['limit'] = $count;
        return $this->view->success_fetch_all($data);
    }

    public function fetch_one($id){
        $data = Reminder::where('user_id',auth()->user()->id)->findOrFail($id);

        return $this->view->success_fetch_one($data);
    }

    public function store(ReminderRequest $request){
        
        $data = Reminder::create([
            'title'=> $request->title,
            'description'=>$request->description,
            'remind_at'=>$request->remind_at,
            'event_at'=>$request->event_at,
            'title'=>$request->title,
            'user_id'=>auth()->user()->id,
        ]);

        return $this->view->success_store($data);

    }

    public function remind_user(){
        $now = now()->timestamp;
        $data= Reminder::where('remind_at',">=",$now)->get();
        foreach($data as $item){
            SendReminderJob::dispatch($item);
        }
    }

    public function update(ReminderRequest $request,$reminder){
        $reminder = Reminder::with('user')->findOrFail($reminder);
        $data = tap($reminder)->update([
            'title'=> $request->title,
            'description'=>$request->description,
            'remind_at'=>$request->remind_at,
            'event_at'=>$request->event_at,
            'title'=>$request->title,
        ]);
        
        
        return $this->view->success_update($data);
    }

    public function destroy($reminder){
        $reminder = Reminder::findOrFail($reminder);
        $reminder->delete();
        return $this->view->success_destroy();
    }
}