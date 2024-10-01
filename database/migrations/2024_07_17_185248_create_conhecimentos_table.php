<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConhecimentosTable extends Migration
{
    public function up()
    {
        Schema::create('conhecimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_conhecimento');
            $table->text('descricao');
            $table->boolean('ativo')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conhecimentos');
    }
}
