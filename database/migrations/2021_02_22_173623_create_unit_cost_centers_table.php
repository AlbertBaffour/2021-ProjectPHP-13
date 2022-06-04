<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitCostCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_cost_centers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id');
            $table->foreignId('cost_center_id');
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete("restrict")->onUpdate('cascade');
            $table->foreign('cost_center_id')->references('id')->on('cost_centers')->onDelete("restrict")->onUpdate('cascade');
        });
        //dummy data
        DB::table('unit_cost_centers')->insert(
            [
                [

                    'unit_id'=>'1',
                    'cost_center_id'=>'1',
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_cost_centers');
    }
}
