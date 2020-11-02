<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(\App\Models\Post::class, function (Faker $faker) {
	$lang=['lv','ru','en'];
	
    return [
        'created_at'=>$faker->dateTimeBetween('-2 days','-1 days'),
		'updated_at'=>$faker->dateTimeBetween('-2 days','-1 days'),
		'user_id'=>rand(1,51),
		'title'=>$faker->realText(rand(10,255)),
		'slug'=>Str::slug($faker->realText(rand(10,255))),
		'text'=>$faker->realText(rand(100,1000)),
		'html'=>$faker->realText(rand(100,1000)),
		'lang'=>$lang[rand(0,2)],
		
    ];
});
