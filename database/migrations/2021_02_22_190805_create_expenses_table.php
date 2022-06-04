<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->float('cost');
            $table->string('description')->nullable();
            $table->float('total_km')->nullable();
            $table->date('date');
            $table->foreignId('expense_allowance_id');
            $table->timestamps();

            $table->foreign('expense_allowance_id')->references('id')->on('expense_allowances')->onDelete('cascade')->onUpdate('cascade');
        });
        //dummy data
        DB::table('expenses')->insert(
            [
                [

                    'cost' => 14,
                    'description'=>'(met auto) bezoek naar KPA, Geel naar Antwerp',
                    'total_km'=>23,
                    'date'=>'2020-10-20',
                    'expense_allowance_id'=>'1'
                ],
                [

                    'cost' => 24.59,
                    'description'=>'(met trein) naar bedrijf x, Geel - Mol',
                    'total_km'=>0,
                    'date'=>'2020-8-25',
                    'expense_allowance_id'=>'2'

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
        Schema::dropIfExists('expenses');
    }
}
