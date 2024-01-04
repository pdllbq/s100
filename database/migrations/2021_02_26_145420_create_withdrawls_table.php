<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('withdrawls', function (Blueprint $table) {
        //     $table->id();
		// 	$table->string('user_name',255);
		// 	$table->float('amount');
		// 	$table->string('full_name',255);
		// 	$table->string('bank_account_number',255);
		// 	$table->integer('processed')->default(0);
			
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
        // Schema::dropIfExists('withdrawls');
    }
}
