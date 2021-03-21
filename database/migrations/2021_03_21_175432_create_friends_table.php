<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->foreignId('user_id')->index('fk_friends_user_idx');
            $table->foreignId('friend_id')->index('fk_friends_friend_idx');
            $table->primary(['user_id', 'friend_id'], 'index');
            $table->foreign('user_id', 'fk_friends_user')->references('id')->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign('friend_id', 'fk_friends_friend')->references('id')->on('users')->onUpdate('no action')->onDelete('no action');

            $table->boolean('accepted')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friends');
    }
}
