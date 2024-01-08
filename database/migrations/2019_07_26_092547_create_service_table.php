<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('shop_id')->nullable();;
            $table->integer('dress_id')->nullable();
            $table->integer('quantity')->nullable();;
            $table->enum('iron', ['1', '0'])->nullable();
            $table->enum('wash', ['1', '0'])->nullable();
            $table->double('amount', 8, 2)->default(0);
            $table->integer('delivery_time')->nullable();
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
        Schema::dropIfExists('services');
    }
}
