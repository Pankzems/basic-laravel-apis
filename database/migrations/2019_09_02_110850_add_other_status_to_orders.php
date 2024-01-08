<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherStatusToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('delperson_id2')->after('delperson_id')->nullable();
            $table->enum('shop_order_status', ['new', 'accept', 'reject', 'inprogress', 'complete'])->after('status')->nullable();
            $table->enum('del_person_order_status', ['new', 'accept', 'reject', 'pick', 'drop', 'inprogress', 'pending', 'complete'])->after('shop_order_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
