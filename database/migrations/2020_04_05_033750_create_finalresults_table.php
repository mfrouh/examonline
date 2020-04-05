<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalresultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finalresults', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->integer('correct');
            $table->integer('wrong');
            $table->integer('notanswer');
            $table->enum('state',['pass','fail']);
            $table->integer('score');
            $table->integer('taked')->default('1');
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
        Schema::dropIfExists('finalresults');
    }
}
