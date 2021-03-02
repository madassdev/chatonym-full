<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsImagesFieldToGroundMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ground_messages', function (Blueprint $table) {
            $table->longText('image_url')->nullable()->default(null);
            $table->string('media_type')->nullable()->default('text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ground_messages', function (Blueprint $table) {
           $table->dropColumn('image_url');
           $table->dropColumn('media_type');
        });
    }
}
