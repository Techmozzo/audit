<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('engagement_id');
            $table->foreign('engagement_id')->references('id')->on('engagements')->onDelete('cascade');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('trial_balance');
            $table->text('test_details')->nullable();
            $table->text('control_testing')->nullable();
            $table->text('journal_entries')->nullable();
            $table->text('material_misstatement')->nullable();
            $table->text('combine_risk_assessment')->nullable();
            $table->text('planning_analytics')->nullable();
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
        Schema::dropIfExists('plannings');
    }
}
