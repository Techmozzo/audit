<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialityBenchmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiality_benchmarks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('planning_id');
            $table->foreign('planning_id')->references('id')->on('plannings');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedInteger('range_id');
            $table->foreign('range_id')->references('id')->on('materiality_ranges');
            $table->decimal('amount', 17, 2);
            $table->string('reason');
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
        Schema::dropIfExists('materiality_benchmarks');
    }
}
