<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        // Add 5 dummy units
        DB::table('units')->insert(
            [
                [
                    'name' => 'IT Factory'
                ],[
                'name' => 'Bouw'
            ],[
                'name' => 'Business and Tourism'
            ],[
                'name' => 'Media and Communication'
            ],[
                'name' => 'People and Health'
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
        Schema::dropIfExists('units');
    }
}
