<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_image_file_name')->after('isd_code')->nullable();
            $table->integer('profile_image_file_size')->after('profile_image_file_name')->nullable();
            $table->string('profile_image_content_type')->after('profile_image_file_size')->nullable();
            $table->timestamp('profile_image_updated_at')->after('profile_image_content_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
