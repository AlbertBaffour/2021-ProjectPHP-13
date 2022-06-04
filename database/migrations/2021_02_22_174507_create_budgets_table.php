<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->float('amount');
            $table->foreignId('cost_center_id');
            $table->timestamps();

            $table->foreign('cost_center_id')->references('id')->on('cost_centers')->onDelete('restrict')->onUpdate('cascade');
        });
        //dummy data
        DB::table('budgets')->insert(
            [
                [

                    'year'=>'2019',
                    'amount'=>20000,
                    'cost_center_id'=>1
                ],[
                'year'=>'2020',
                'amount'=>35000,
                'cost_center_id'=>2
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
        Schema::dropIfExists('budgets');
    }
}
