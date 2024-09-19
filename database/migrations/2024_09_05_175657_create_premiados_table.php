<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiadosTable extends Migration
{
    public function up()
    {
        Schema::create('premiados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained()->onDelete('cascade');
            $table->foreignId('olimpiada_id')->constrained()->onDelete('cascade');
            $table->enum('medalha', ['ouro', 'prata', 'bronze']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('premiados');
    }
}
