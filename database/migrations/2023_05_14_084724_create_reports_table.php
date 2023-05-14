<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officer_reports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id')->nullable();
            $table->integer('year_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('generated_by')->nullable();
            $table->integer('total_budget')->nullable();
            $table->text('comment')->nullable();
            $table->string('submited')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('officer_reports');
    }
}
