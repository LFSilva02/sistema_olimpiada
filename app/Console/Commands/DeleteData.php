<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Turma; 

class DeleteData extends Command
{
    // O nome e a descrição do comando
    protected $signature = 'data:delete {id}'; // Adicione um parâmetro de ID
    protected $description = 'Delete data from the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $id = $this->argument('id'); // Obtém o argumento ID

        $record = Turma::find($id);

        if ($record) {
            $record->delete();
            $this->info("Record with ID $id has been deleted.");
        } else {
            $this->error("Record with ID $id not found.");
        }

        return 0;
    }
}
