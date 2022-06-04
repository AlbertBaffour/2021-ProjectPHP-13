<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_centers', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('name');
            $table->foreignId('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete("set null")->onUpdate('cascade');
        });
        // Add dummy cost centers
        DB::table('cost_centers')->insert(
            [   [
                'reference' => "WZZ60000000",
                'name' => "Transport",
                'user_id' => "2"
                ],[
                    'reference' => "WU5G11111111",
                    'name' => "Technology stage1",
                    'user_id' => "2"
                ],[
                    'reference' => "WUEIGE02274 ",
                    'name' => "Buitenlandse reis",
                    'user_id' => "2"
                ],[
                    'reference' => "WU3BWG800000",
                    'name' => "BW Beleid en Opleidingsinitiatieven",
                    'user_id' => "2"
                ],[
                    'reference' => "WU3BWG801000",
                    'name' => "BW Professionalisering Personeel ",
                    'user_id' => "2"
                ],[
                    'reference' => "WU3BWGE12000BW",
                    'name' => "Studentenrekening ",
                    'user_id' => "2"
                ],[
                    'reference' => "WUJEMGV01101",
                    'name' => "CNO ",
                    'user_id' => "2"
                ],[
                    'reference' => "WU3ZZGZ88888",
                    'name' => "Corona Unit 3",
                    'user_id' => "2"
                ],[
                    'reference' => "WU3ZZGB03040",
                    'name' => "CreateCave",
                    'user_id' => "2"
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
        Schema::dropIfExists('cost_centers');
    }
}
