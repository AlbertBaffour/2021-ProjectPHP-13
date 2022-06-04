<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaptopAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laptop_allowances', function (Blueprint $table) {
            $table->id();
            $table->integer('period')->nullable();
            $table->foreignId('cost_center_id');
            $table->foreignId('laptop_id');
            $table->foreignId('user_id');
            $table->foreignId('financial_officer_id')->nullable();
            $table->foreignId('cost_center_manager_id')->nullable();
            $table->foreignId('cost_setting_id')->nullable();
            $table->foreignId('status_id');
            $table->date('approval_date')->nullable();
            $table->date('finance_approval_date')->nullable();
            $table->string('comment')->nullable();
            $table->string('finance_comment')->nullable();
            $table->timestamps();

            $table->foreign('cost_center_id')->references('id')->on('cost_centers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('laptop_id')->references('id')->on('laptops')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('financial_officer_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cost_center_manager_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cost_setting_id')->references('id')->on('cost_settings')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laptop_allowances');
    }
}
