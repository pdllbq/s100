<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\User;

class UpdatePostsDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdatePostsDb';

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
		$posts=Post::select('*')->get();
		
		foreach($posts as $post){
			$user=User::where('id',$post->user_id)->first();
			
			Post::where('id',$post->id)->update([
				'user_name'=>$user->name,
			]);
		}
		
        return 0;
    }
}
