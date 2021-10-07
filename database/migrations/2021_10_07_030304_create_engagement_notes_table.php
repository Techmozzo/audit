<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngagementNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engagement_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('message');
            $table->unsignedInteger('engagement_note_flag_id');
            $table->foreign('engagement_note_flag_id')->references('id')->on('engagement_note_flags');
            $table->unsignedInteger('engagement_stage_id');
            $table->foreign('engagement_stage_id')->references('id')->on('engagement_stages');
            $table->unsignedInteger('engagement_id');
            $table->foreign('engagement_id')->references('id')->on('engagements')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('engagement_notes');
    }
}
