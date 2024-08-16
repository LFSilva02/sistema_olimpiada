<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurmasTable extends Migration
{
    public function up()
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->string('nome_turma');
            $table->string('serie');
            $table->year('ano');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('turmas');
    }
}
