<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function(Blueprint $table) {
            $table->increments('id');
            $table->string('company');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->text('bank_details');
            $table->integer('logo_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('logo_id')
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
        Schema::table('settings', function(Blueprint $table) {
            $table->dropForeign(['logo_id']);
        });

        Schema::drop('settings');
    }
}
