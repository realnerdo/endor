<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function(Blueprint $table) {
            $table->increments('id');
            $table->string('to');
            $table->string('subject');
            $table->text('message');
            $table->integer('opened_times')->nullable();
            $table->datetime('opened_at')->nullable();
            $table->integer('estimate_id')->unsigned();
            $table->timestamps();
            $table->foreign('estimate_id')
                    ->references('id')
                    ->on('estimates')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emails', function(Blueprint $table) {
            $table->dropForeign(['estimate_id']);
        });
        Schema::drop('emails');
    }
}
