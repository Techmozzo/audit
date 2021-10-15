<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materialities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('materiality_level_id');
            $table->foreign('materiality_level_id')->references('id')->on('materiality_levels');
            $table->unsignedInteger('planning_id');
            $table->foreign('planning_id')->references('id')->on('plannings')->onDelete('cascade');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->decimal('limit', 5, 2);
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
        Schema::dropIfExists('materialities');
    }
}
