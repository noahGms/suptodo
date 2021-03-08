<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todoitems', function (Blueprint $table) {
            $table->id();
            $table->string('description', 255);
            $table->foreignId('todolist_id')->index('fk_todoitems_todolist_idx');
            $table->foreign('todolist_id', 'fk_todoitems_todolist')->references('id')->on('todolists')->onUpdate('no action')->onDelete('cascade');
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
        Schema::dropIfExists('todoitems');
    }
}
