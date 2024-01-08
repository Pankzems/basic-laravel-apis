<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('city_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('zipcode')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->enum('current', ['1', '0'])->default(0);
            $table->enum('status', ['1', '0'])->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
