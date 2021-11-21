<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engagements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('name');
            $table->year('year');
            $table->integer('first_time');
            $table->string('audit_id')->unique();
            $table->text('engagement_letter');
            $table->text('accounting_standard');
            $table->text('auditing_standard');
            $table->text('external_expert')->nullable();
            $table->text('appointment_letter')->nullable();
            $table->text('contacted_previous_auditor')->nullable();
            $table->text('previous_auditor_response')->nullable();
            $table->text('previous_audit_opinion')->nullable();
            $table->text('other_audit_opinion')->nullable();
            $table->text('previous_audit_review')->nullable();
            $table->text('previous_year_management_letter')->nullable();
            $table->text('previous_year_asf')->nullable();
            $table->unsignedInteger('status');
            $table->foreign('status')->references('id')->on('engagement_stages');
            $table->softDeletes();
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
        Schema::dropIfExists('engagements');
    }
}
