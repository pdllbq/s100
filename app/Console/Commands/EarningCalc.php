<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PostsReaded;
use App\Models\Post;
use App\User;

class EarningCalc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:earningCalc';

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
        $data=PostsReaded::where('payed',0)->get()->toArray();
		
		$this->info('Earning sum for a day: '.env('EARNING_SUM_FOR_A_DAY'));
		
		$count=count($data);
		
		$this->info('New watches: '.$count);
		
		@$payForWatch=env('EARNING_SUM_FOR_A_DAY')/$count;
		@$referralPercent=$payForWatch/100*10;
		
		$this->info('Pay for watch: '.$payForWatch);
		$this->info('Referral pay: '.$referralPercent);
		
		foreach($data as $value){
			$post=Post::where('slug',$value['slug'])->first();
			if(isset($post->id)){
			
				Post::where('slug',$post->slug)->increment('earned',$payForWatch);
				
				User::where('id',$post->user_id)->increment('balance',$payForWatch);
				User::where('id',$post->user_id)->increment('total_earned',$payForWatch);
				
				if(isset($post->user->referral)){
					User::where('name',$post->user->referral)->increment('balance',$referralPercent);
				}
			}
			
			PostsReaded::where('id',$value['id'])->update(['payed'=>1]);
		}
    }
}
