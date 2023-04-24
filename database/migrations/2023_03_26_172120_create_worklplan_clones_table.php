<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorklplanClonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worklplan_clones', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('source_id')->default(NULL);
            $table->integer('destination_id')->default(NULL);
            $table->integer('created_by')->default(NULL);
            $table->text('description')->default(NULL);
            $table->string('processed')->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worklplan_clones');
    }
}
