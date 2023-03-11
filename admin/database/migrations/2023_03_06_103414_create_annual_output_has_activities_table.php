<?php

use App\Models\Activity;
use App\Models\AnnualOutput;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnualOutputHasActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annual_output_has_activities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(AnnualOutput::class);
            $table->foreignIdFor(Activity::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('annual_output_has_activities');
    }
}
