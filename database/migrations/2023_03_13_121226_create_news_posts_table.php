<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();

            $table->tinyText('creator');
            $table->text('title');
            $table->text('link');
            $table->tinyText('pub_date');
            $table->longText('content');
            $table->longText('content_snippet');
            $table->text('guid');
            $table->text('img_url');
            $table->tinyText('domain');
            $table->bigInteger('filter_id');
            $table->string('language', 2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_posts');
    }
};
