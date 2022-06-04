<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBicycleAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bicycle_allowances', function (Blueprint $table) {
            $table->id();
            $table->date('submission_date');
            $table->date('payment_date');
            $table->float('amount_per_km');
            $table->foreignId('user_id');
            $table->foreignId('financial_officer_id')->nullable();
            $table->foreignId('cost_setting_id')->nullable();
            $table->foreignId('status_id');
            $table->foreignId('cost_center_id');
            $table->date('approval_date')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('financial_officer_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cost_setting_id')->references('id')->on('cost_settings')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('cost_center_id')->references('id')->on('cost_centers')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bicycle_allowances');
    }
}
