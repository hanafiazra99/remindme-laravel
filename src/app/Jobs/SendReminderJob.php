<?php

namespace App\Jobs;

use App\Mail\ReminderEmail;
use App\Models\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $reminder;
    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
        
        
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        

        Mail::to($this->reminder->user->email)
            ->send(new ReminderEmail($this->reminder));
            
        
    }
}
