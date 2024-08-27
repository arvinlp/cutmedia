<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('serie_id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('excerpt')->nullable();
            $table->text('description');
            $table->string('thumb')->nullable();
            $table->string('cover')->nullable();
            $table->string('file')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_commented')->default(false);
            $table->boolean('is_special')->default(false);
            $table->set('type', ['video', 'audio'])->default('video');
            $table->string('rate',100)->default('0.0');
            $table->integer('view')->default(0);
            $table->timestamps();
            $table->softDeletes();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');
        });
        Schema::table('episodes', function (Blueprint $table) {
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodes');
    }
}
