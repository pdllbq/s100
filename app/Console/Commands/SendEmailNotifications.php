<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailNotification;
use App\Mail\NotificationEmail;

class SendEmailNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendEmailNotifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$emails=EmailNotification::get();
		foreach($emails as $data){			
			$e=new NotificationEmail;
			$e->subject=$data->subject;
			$e->message=$data->message;
			Mail::to($data->email)->send($e);
			
			EmailNotification::where('id',$data->id)->delete();
		}
		
        return 0;
    }
}
