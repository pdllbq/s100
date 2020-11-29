<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTempSavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_temp_saves', function (Blueprint $table) {
            $table->id();
			
			$table->string('user_name');
			$table->string('title',255);
			$table->text('group_slug');
			$table->longText('text');
            $table->timestamps();
			
			$table->index(['user_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_temp_saves');
    }
}
