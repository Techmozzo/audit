<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssertionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assertions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transaction_test_id');
            $table->foreign('transaction_test_id')->references('id')->on('transaction_tests')->onDelete('cascade');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedSmallInteger('completeness')->default(0);
            $table->unsignedSmallInteger('existence')->default(0);
            $table->unsignedSmallInteger('accuracy')->default(0);
            $table->unsignedSmallInteger('valuation')->default(0);
            $table->unsignedSmallInteger('obligation_right')->default(0);
            $table->unsignedSmallInteger('disclosure_presentation')->default(0);
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
        Schema::dropIfExists('assertions');
    }
}
