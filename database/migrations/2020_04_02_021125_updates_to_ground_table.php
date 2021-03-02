<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatesToGroundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grounds', function (Blueprint $table) {
           $table->renameColumn('title','description');
           $table->string('img_url')->nullable()->default(null);
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
           $table->renameColumn('description','title');
           $table->dropColumn('img_url');
        });
    }
}
