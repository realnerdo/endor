<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EstimateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_sections', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content');
            $table->integer('estimate_service_id')->unsigned();
            $table->timestamps();

            $table->foreign('estimate_service_id')
                    ->references('id')
                    ->on('estimate_services')
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
        Schema::table('estimate_sections', function(Blueprint $table) {
            $table->dropForeign(['estimate_service_id']);
        });

        Schema::drop('estimate_sections');
    }
}
