<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('picture_id')->unsigned()->nullable();
            $table->enum('role', ['admin', 'executive'])->default('executive');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('picture_id')
                    ->references('id')
                    ->on('pictures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign(['picture_id']);
        });
        Schema::dropIfExists('users');
    }
}
