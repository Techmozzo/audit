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
            $table->string('engagement_letter');
            $table->string('accounting_standard');
            $table->string('auditing_standard');
            $table->string('staff_power');
            $table->string('partner_skill');
            $table->string('external_expert');
            $table->string('members_dependence');
            $table->string('appointment_letter')->nullable();
            $table->string('contacted_previous_auditor')->nullable();
            $table->string('previous_auditor_response')->nullable();
            $table->string('previous_audit_opinion')->nullable();
            $table->string('other_audit_opinion')->nullable();
            $table->string('previous_audit_review')->nullable();
            $table->string('previous_year_management_letter')->nullable();
            $table->string('previous_year_asf')->nullable();
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
