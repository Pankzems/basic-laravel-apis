<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('shop_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('delperson_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('price', 8, 2)->default(0);
            $table->double('tax', 8, 2)->default(0);
            $table->double('total', 8, 2)->default(0);
            $table->enum('status', ['new', 'accept', 'reject', 'inprogress', 'complete'])->default('new');
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
        Schema::dropIfExists('orders');
    }
}
