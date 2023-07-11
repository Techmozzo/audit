<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('planning_id')->nullable();
            $table->foreign('planning_id')->references('id')->on('plannings')->onDelete('cascade');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('name');
            $table->string('process_flow_document')->nullable();
            $table->string('work_through')->nullable();
            $table->string('risk_material_misstatement')->nullable();
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
        Schema::dropIfExists('transaction_classes');
    }
}
