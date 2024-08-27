<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nickname')->default('کاربر');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile',14)->unique();
            $table->string('password')->nullable();
            $table->string('tel')->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->string('wallet')->default("0");
            $table->unsignedSmallInteger('province')->default(8);
            $table->unsignedSmallInteger('county')->default(103);
            $table->unsignedSmallInteger('city')->default(329);
            $table->boolean('is_married')->default(false);
            $table->set('type', ['admin', 'user'])->default('user');
            $table->boolean('status')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        
            $table->collation = env('DB_CHARACTER', 'utf8_general_ci');
            
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('province')->references('id')->on('provinces')->onDelete('cascade');
            $table->foreign('county')->references('id')->on('counties')->onDelete('cascade');
            $table->foreign('city')->references('id')->on('cities')->onDelete('cascade');
            $table->unique(['mobile'],'users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
