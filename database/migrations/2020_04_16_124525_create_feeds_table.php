<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            
            $table->unsignedBigInteger('parent_id')->nullable()->default(null);
            $table->unsignedBigInteger('user_id')->nullable()->default(null);

            $table->text('message')->nullable()->default(null);

            $table->string('media_type')->nullable()->default('text');

            $table->longText('image_url')->nullable()->default(null);

            $table->string('audio_url')->nullable()->default(null);
            $table->string('warped_audio_url')->nullable()->default(null);
            $table->string('warp_effect')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->unsignedBiginteger('reactions_count')->nullable()->default(0);
            $table->string('user_ip')->nullable()->default(null);
            $table->text('user_agent')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeds');
    }
}
