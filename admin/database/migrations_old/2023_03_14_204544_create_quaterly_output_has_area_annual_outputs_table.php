<?php

use App\Models\AnnualOutput;
use App\Models\AnnualOutputHasActivity;
use App\Models\QuaterlyOutput;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuaterlyOutputHasAreaAnnualOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quaterly_output_has_area_annual_outputs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(AnnualOutputHasActivity::class);
            $table->foreignIdFor(QuaterlyOutput::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quaterly_output_has_area_annual_outputs');
    }
}
