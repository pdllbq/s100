<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsReadedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('posts_readed', function (Blueprint $table) {
        //     $table->id();
			
		// 	$table->string('slug',255);
		// 	$table->ipAddress('ip');
		// 	$table->string('user_name',191)->nullable();
			
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('posts_readeds');
    }
}
