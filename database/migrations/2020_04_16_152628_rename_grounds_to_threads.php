<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameGroundsToThreads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('grounds', 'threads');
        Schema::rename('ground_messages', 'thread_messages');

        Schema::table('thread_messages', function (Blueprint $table) {
            $table->renameColumn('ground_id','thread_id');
        });
        Schema::table('reactions', function (Blueprint $table) {
            $table->renameColumn('ground_message_id','thread_message_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('threads', 'grounds');
        Schema::rename('thread_messages', 'ground_messages');

        Schema::table('ground_messages', function (Blueprint $table) {
            $table->renameColumn('thread_id','ground_id');
        });
        Schema::table('reactions', function (Blueprint $table) {
            $table->renameColumn('thread_message_id','ground_message_id');
        });
    }
}
