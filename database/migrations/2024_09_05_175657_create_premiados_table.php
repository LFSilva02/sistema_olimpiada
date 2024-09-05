<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premiados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aluno_id'); // Referência para o ID do aluno
            $table->string('medalha');
            $table->string('olimpiada');
            $table->timestamps();

            // Definir a chave estrangeira
            $table->foreign('aluno_id')->references('id')->on('alunos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premiados');
    }
}
