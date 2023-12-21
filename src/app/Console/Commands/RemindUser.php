<?php

namespace App\Console\Commands;

use App\Presenters\ReminderPresenter;
use Illuminate\Console\Command;

class RemindUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email to the user';

    /**
     * Execute the console command.
     */
    protected $reminder_presenter;
     public function __construct(ReminderPresenter $reminder_presenter) {
        parent::__construct();
        $this->reminder_presenter = $reminder_presenter;
     }
    public function handle()
    {
        $this->reminder_presenter->remind_user();
    }
}
