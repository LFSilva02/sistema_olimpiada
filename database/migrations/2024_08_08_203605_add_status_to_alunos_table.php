<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAlunosTable extends Migration
{
    public function up()
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('status')->default('ativo'); // Adiciona a coluna status com valor padrão 'ativo'
        });
    }

    public function down()
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropColumn('status'); // Remove a coluna status
        });
    }
}
