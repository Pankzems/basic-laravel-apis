<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->text('name')->nullable();
            $table->text('address')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('zipcode')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
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
        Schema::dropIfExists('shops');
    }
}
