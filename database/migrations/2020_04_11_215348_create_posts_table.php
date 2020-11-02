<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('user_id')->unsigned();
			$table->bigInteger('votes_up')->default(0);
			$table->bigInteger('votes_down')->default(0);
			$table->bigInteger('24h_rating')->default(0);
			$table->string('title',255);
			$table->string('slug',255)->default(NULL);
			$table->longText('text');
			$table->longText('html')->default(NULL);
			$table->longText('files')->default(NULL);
			$table->string('lang',2);
			$table->string('tags',1024)->default(NULL);
			
			$table->index(['24h_rating']);
			
			$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
