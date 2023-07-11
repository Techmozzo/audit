<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcedureAssertionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedure_assertions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('procedure_id');
            $table->foreign('procedure_id')->references('id')->on('procedures')->onDelete('cascade');
            $table->unsignedInteger('assertion_id');
            $table->foreign('assertion_id')->references('id')->on('assertions')->onDelete('cascade');
            $table->unsignedSmallInteger('value')->default(0);
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
        Schema::dropIfExists('procedure_assertions');
    }
}
