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
            $table->integer('completeness')->default(0);
            $table->integer('existence')->default(0);
            $table->integer('accuracy')->default(0);
            $table->integer('valuation')->default(0);
            $table->integer('obligation_right')->default(0);
            $table->integer('disclosure_presentation')->default(0);
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
