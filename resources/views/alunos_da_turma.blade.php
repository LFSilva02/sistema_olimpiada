<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Alunos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
</head>
<body class="bg-white">

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Lista de Alunos</h1>

        <!-- Lista de alunos com botão de editar -->
        <div class="mb-4">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Nome</th>
                        <th class="py-2 px-4 border-b">Turma</th>
                        <th class="py-2 px-4 border-b">Ativo</th>
                        <th class="py-2 px-4 border-b">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alunos as $aluno)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $aluno->nome }}</td>
                        <td class="py-2 px-4 border-b">{{ $aluno->turma->nome_turma }}</td>
                        <td class="py-2 px-4 border-b">{{ $aluno->ativo ? 'Sim' : 'Não' }}</td>
                        <td class="py-2 px-4 border-b">
                            <button class="bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-1 px-2 rounded openEditFormButton"
                                    data-id="{{ $aluno->id }}"
                                    data-nome="{{ $aluno->nome }}"
                                    data-turma="{{$aluno->turma->turma_id}}"
                                    data-ativo="{{ $aluno->ativo }}">
                                Editar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formulário para editar alunos -->
    <div id="formContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <h2 class="text-2xl font-bold mb-4">Editar Aluno</h2>
            <form id="editform" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="alunoId" name="aluno_id" value="">
                <div class="mb-4">
                    <label for="nomeAluno" class="block text-sm font-medium text-gray-700">Nome do Aluno</label>
                    <input type="text" name="nome" id="nomeAluno" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="turma_nome" class="block text-sm font-medium text-gray-700">Turma</label>
                    <select name="turma_nome" id="turma_nome" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="">Selecione uma turma</option>
                        @foreach($turmas as $turma)
                            <option value="{{ $turma->id }}" {{ $aluno->turma_id == $turma->id ? 'selected' : '' }}>
                                {{ $turma->nome_turma }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="ativo" class="block text-sm font-medium text-gray-700">Ativo</label>
                    <select name="ativo" id="ativo" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded">Salvar</button>
                    <button type="button" id="cancelFormButton" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const editFormButtons = document.querySelectorAll('.openEditFormButton');
        const formContainer = document.getElementById('formContainer');

        editFormButtons.forEach(button => {
            button.addEventListener('click', function() {
                const alunoId = this.getAttribute('data-id');
                const nomeAluno = this.getAttribute('data-nome');
                const turma_nome = this.getAttribute('data-turma');
                const ativoAluno = this.getAttribute('data-ativo');


                // Preenche os campos do formulário com os dados do aluno
                document.getElementById('alunoId').value = alunoId;
                document.getElementById('nomeAluno').value = this.getAttribute('data-nome');
                document.getElementById('turma_nome').value = turma_nome;
                document.getElementById('ativo').value = ativoAluno;

                // Exibe o formulário
                formContainer.classList.remove('hidden');

                // Define a ação do formulário para o ID do aluno
                document.getElementById('editform').action = `/alunos/${alunoId}`;
            });
        });

        document.getElementById('cancelFormButton').addEventListener('click', function() {
            // Fecha o formulário sem alterar nada
            formContainer.classList.add('hidden');
        });
    </script>
</body>
</html>
