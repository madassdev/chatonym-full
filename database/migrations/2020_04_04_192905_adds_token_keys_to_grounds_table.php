<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsTokenKeysToGroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grounds', function (Blueprint $table) {
            $table->text('secret')->nullable()->default(null);
            $table->text('token')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grounds', function (Blueprint $table) {
            $table->dropColumn('secret');
            $table->dropColumn('token');
        });
    }
}
