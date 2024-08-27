<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('excerpt')->nullable();
            $table->text('description');
            $table->string('thumb')->nullable();
            $table->string('cover')->nullable();
            $table->string('cover_2')->nullable();
            $table->string('header')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_commented')->default(false);
            $table->boolean('is_homepage')->default(false);
            $table->set('type', ['video', 'audio'])->default('video');
            $table->string('rate',100)->default('0.0');
            $table->integer('view')->default(0);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series');
    }
}
