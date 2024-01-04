<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('subscribes', function (Blueprint $table) {
        //     $table->id();
		// 	$table->bigInteger('master_id');
		// 	$table->bigInteger('slave_id')->default(0);
		// 	$table->bigInteger('group_id')->default(0);
		// 	$table->string('tag_name','255')->nullable();
        //     $table->timestamps();
			
		// 	$table->index(['master_id','slave_id','group_id','tag_name']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('subscribes');
    }
}
