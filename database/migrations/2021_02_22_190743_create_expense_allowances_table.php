<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_allowances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('submission_date');
            $table->date('payment_date')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('financial_officer_id')->nullable();
            $table->foreignId('cost_center_manager_id')->nullable();
            $table->foreignId('status_id');
            $table->foreignId('cost_center_id');
            $table->date('approval_date')->nullable();
            $table->date('finance_approval_date')->nullable();
            $table->string('comment')->nullable();
            $table->string('finance_comment')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('financial_officer_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cost_center_manager_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('cost_center_id')->references('id')->on('cost_centers')->onDelete('restrict')->onUpdate('cascade');
        });
        //dummy data
        DB::table('expense_allowances')->insert(
            [
                [

                    'name' => 'Inter. days',
                    'submission_date'=>'2020-12-12',
                    'user_id'=>'1',
                    'status_id'=>'1',
                    'cost_center_id'=>'1'
                ],[

                    'name' => 'Jobbeurs',
                    'submission_date'=>'2021-02-12',
                    'user_id'=>'1',
                    'status_id'=>'3',
                    'cost_center_id'=>'2'
                ],[

                    'name' => 'Jobbeurs',
                    'submission_date'=>'2021-02-12',
                    'user_id'=>'1',
                    'status_id'=>'2',
                    'cost_center_id'=>'2'
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
        Schema::dropIfExists('expense_allowances');
    }
}
