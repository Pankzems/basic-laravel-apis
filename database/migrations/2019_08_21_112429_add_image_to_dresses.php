<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageToDresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dresses', function (Blueprint $table) {
            $table->string('image_file_name')->after('category_id')->nullable();
            $table->integer('image_file_size')->after('image_file_name')->nullable();
            $table->string('image_content_type')->after('image_file_size')->nullable();
            $table->timestamp('image_updated_at')->after('image_content_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dresses', function (Blueprint $table) {
            //
        });
    }
}
