<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function(Blueprint $table) {
            $table->increments('id');
            $table->string('folio');
            $table->enum('status', ['En espera', 'Vendida', 'No vendida'])->default('En espera');
            $table->string('service');
            $table->text('description');
            $table->float('total')->nullable();
            $table->float('discount')->nullable();
            $table->integer('client_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients');

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estimates', function(Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::drop('estimates');
    }
}
