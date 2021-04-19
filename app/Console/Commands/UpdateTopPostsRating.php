<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Rating;

class UpdateTopPostsRating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateRating';

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
		$posts=Post::where('draft','!=',1)->where('in_sandbox','!=',1)->orderBy('24h_rating','desc')->orderBy('id','desc')->limit(60)->get();
		
		$Rating=new Rating;
		
		foreach($posts as $post){
			$Rating->getRating($post->slug);
			echo'Updated '.$post->slug.PHP_EOL;
		}
		
        return 0;
    }
}
