<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->float('value');
            $table->foreignId('cost_center_id');
            $table->timestamps();

            $table->foreign('cost_center_id')->references('id')->on('cost_centers')->onDelete('restrict')->onUpdate('cascade');
        });
        //dummy data
        DB::table('cost_settings')->insert(
            [
                [
                    'name' => 'perKmCar',
                    'description'=>'Vergoeding per km met auto',
                    'value'=>0.50,
                    'cost_center_id'=>'1'
                ],
                [
                    'name' => 'perKmBike',
                    'description'=>'Vergoeding per km met fiets',
                    'value'=>1.75,
                    'cost_center_id'=>'1'
                ],
                [
                    'name' => 'laptop',
                    'description'=>'Vergoeding per laptop',
                    'value'=>700,
                    'cost_center_id'=>'1'
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cost_settings');
    }
}
