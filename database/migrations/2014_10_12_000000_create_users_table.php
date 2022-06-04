<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->date('date_of_birth');
            $table->string('street_and_number');
            $table->string('postcode');
            $table->string('place');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('telephone')->nullable();
            $table->date('start_date');
            $table->foreignId('personnel_type_id');
            $table->float('total_km')->nullable();
            $table->foreignId('unit_id')->nullable();
            $table->string('account_number')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('admin')->default(false);
            $table->timestamps();

            $table->foreign('personnel_type_id')->references('id')->on('personnel_types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete("set null")->onUpdate('cascade');
        });
        //dummy users
        DB::table('users')->insert(
            [
                [

                    'last_name' => 'Docie ',
                    'first_name' => 'Smith',
                    'date_of_birth'=>'1991-01-01',
                    'street_and_number'=>'Taxandria 12',
                    'postcode'=>'2300',
                    'place'=>'Turnhout',
                    'email' => 'docie.test@gmail.com',
                    'password' => Hash::make('thomasmore'),
                    'telephone'=>'',
                    'start_date'=>'2020-08-12',
                    'personnel_type_id'=>'1',
                    'total_km'=>23,
                    'unit_id'=>'1',
                    'account_number'=>'',
                    'active'=>true,
                    'admin' => false,

                    'created_at' => now(),
                    'updated_at'=> now(),
                    'email_verified_at' => now()
                ],[

                'last_name' => 'Verant ',
                'first_name' => 'Jos',
                'date_of_birth'=>'1988-01-01',
                'street_and_number'=>'Taxandriastraat 11',
                'postcode'=>'2300',
                'place'=>'Turnhout',
                'email' => 'verant@gmail.com',
                'password' => Hash::make('pass1234'),
                'telephone'=>'',
                'start_date'=>'2020-08-12',
                'personnel_type_id'=>'2',
                'total_km'=>43,
                'unit_id'=>'1',
                'account_number'=>'',
                'active'=>true,
                'admin' => false,

                'created_at' => now(),
                'updated_at'=> now(),
                'email_verified_at' => now()
            ],[

                'last_name' => 'Finae',
                'first_name' => 'Steve',
                'date_of_birth'=>'1985-01-02',
                'street_and_number'=>'Taxandriastraat 11',
                'postcode'=>'2300',
                'place'=>'Turnhout',
                'email' => 'finae@gmail.com',
                'password' => Hash::make('pass1234'),
                'telephone'=>'',
                'start_date'=>'2020-06-12',
                'personnel_type_id'=>'3',
                'total_km'=>28,
                'unit_id'=>'1',
                'account_number'=>'',
                'active'=>true,
                'admin' => true,

                'created_at' => now(),
                'updated_at'=> now(),
                'email_verified_at' => now()
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
        Schema::dropIfExists('users');
    }
}
