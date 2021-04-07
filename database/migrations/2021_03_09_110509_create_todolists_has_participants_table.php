<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodolistsHasParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todolists_has_participants', function (Blueprint $table) {
            $table->foreignId('todolist_id')->index('fk_todolist_has_participants_todolist_idx');
            $table->foreignId('user_id')->index('fk_todolist_has_participants_user_idx');
            $table->primary(['todolist_id', 'user_id'], 'index');
            $table->foreign('todolist_id', 'fk_todolist_has_participants_todolist')->references('id')->on('todolists')->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id', 'fk_todolist_has_participants_user')->references('id')->on('users')->onUpdate('no action')->onDelete('cascade');

            $table->boolean('accepted')->nullable();
            $table->string('permissions', 2)->default('rw');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todolists_has_participants');
    }
}
