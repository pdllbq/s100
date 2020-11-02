<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('user_id');
			$table->bigInteger('rating')->default(0);
			$table->bigInteger('answer_id')->default(NULL); // Id коментария, на который ответ
			$table->string('post_slug',255)->default(NULL);
			$table->longText('text');
			
			$table->index(['post_slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
