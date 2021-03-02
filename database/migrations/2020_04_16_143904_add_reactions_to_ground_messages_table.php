<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReactionsToGroundMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ground_messages', function (Blueprint $table) {            
            $table->unsignedBiginteger('reactions_count')->nullable()->default(0);
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
           $table->dropColumn('reactions_count');
            
        });
    }
}
