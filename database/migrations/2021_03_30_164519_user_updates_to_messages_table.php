<?php

use App\Models\FirebaseNotification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserUpdatesToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('firebase_notifications', function (Blueprint $table) {
            $table->string('key')->nullable();
        });

        FirebaseNotification::all()->map(function($d){
            $d->key = md5($d->token);
            $d->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            
        });
    }
}
