<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_services', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content')->nullable(); // Delete
            $table->text('notes');
            $table->float('price');
            $table->integer('duration');
            $table->integer('offset');
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
        Schema::table('estimate_services', function(Blueprint $table) {
            $table->dropForeign(['estimate_id']);
        });

        Schema::drop('estimate_services');
    }
}
