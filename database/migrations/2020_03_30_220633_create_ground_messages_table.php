<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroundMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ground_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            
            $table->unsignedBigInteger('parent_id')->nullable()->default(null);
            $table->unsignedBigInteger('ground_id')->nullable()->default(null);

            $table->text('message')->nullable()->default(null);

            $table->string('audio_url')->nullable()->default(null);
            $table->string('warped_audio_url')->nullable()->default(null);
            $table->string('warp_effect')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);

            $table->string('user_ip')->nullable()->default(null);
            $table->string('user_agent')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('ground_id')->references('id')->on('grounds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ground_messages');
    }
}
