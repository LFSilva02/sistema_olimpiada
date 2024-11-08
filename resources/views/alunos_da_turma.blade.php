<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Alunos</title>
    <!-- Adicionando o Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <style>
        .sidebar-hidden {
            transform: translateX(-100%);
        }

        .sidebar-visible {
            transform: translateX(0);
        }

        .transition-transform {
            transition: transform 0.3s ease-in-out;
        }

        .inactive {
            background-color: #d1d5db;
            color: #6b7280;
        }
    </style>
</head>

<body class="bg-white">

    <!-- Cabeçalho -->
    <div class="header bg-[#134196] text-white py-4 text-center fixed w-full z-10 flex justify-center items-center px-4">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('storage/img/colegiolondrinense.png') }}" alt="Logo" class="h-14">
            <h1 class="text-xl font-bold">Olimpíadas Científicas Colégio Londrinense</h1>
        </div>
    </div>

    @include('components.sidebar')

    <div class="pt-20 mb-8 flex justify-center items-center">
        <div class="text-center">
            <h1 class="text-3xl mt-16 mb-12 font-bold">Edição de alunos</h1>
        </div>
    </div>

    <!-- Lista de alunos com botão de editar e inativar -->
    <div class="mb-4 mt-16">
        <table class="min-w-full bg-white text-center">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Nome</th>
                    <th class="py-2 px-4 border-b">Turma</th>
                    <th class="py-2 px-4 border-b">Ativo</th>
                    <th class="py-2 px-4 border-b">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alunos as $aluno)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $aluno->nome }}</td>
                        <td class="py-2 px-4 border-b">{{ $aluno->turma->nome_turma }}</td>
                        <td class="py-2 px-4 border-b">{{ $aluno->ativo ? 'Sim' : 'Não' }}</td>
                        <td class="py-2 px-4 border-b">
                            <!-- Botão Editar -->
                            <button class="bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-1 px-2 rounded openEditFormButton"
                                data-id="{{ $aluno->id }}" data-nome="{{ $aluno->nome }}"
                                data-turma="{{ $aluno->turma_id }}" data-ativo="{{ $aluno->ativo }}">
                                Editar
                            </button>

                            <!-- Botão Ativar/Inativar -->
                            @if ($aluno->ativo)
                                <form action="{{ route('alunos.inativar', ['id' => $aluno->id]) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded">
                                        Inativar
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('alunos.ativar', ['id' => $aluno->id]) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-green-500 hover:bg-green-400 text-white font-bold py-1 px-2 rounded">
                                        Ativar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
                    <input type="text" name="nome" id="nomeAluno"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                </div>

                <div class="mb-4">
                    <label for="turma_nome" class="block text-sm font-medium text-gray-700">Turma</label>
                    <select name="turma_id" id="turma_nome"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                        @foreach ($turmas as $turma)
                            <option value="{{ $turma->id }}" {{ $aluno->turma_id == $turma->id ? 'selected' : '' }}>{{ $turma->nome_turma }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="ativo" class="block text-sm font-medium text-gray-700">Ativo</label>
                    <select name="ativo" id="ativo"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="flex justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded">Salvar</button>
                    <button type="button" id="cancelFormButton"
                        class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-[#134196] text-white py-4 text-center mt-4 fixed bottom-0 w-full">
        <div class="container mx-auto">
            <p class="text-sm">&copy; {{ date('Y') }} Olimpíadas Científicas Colégio Londrinense. Todos os direitos
                reservados.</p>
        </div>
    </footer>

    <script>
        const editFormButtons = document.querySelectorAll('.openEditFormButton');
        const formContainer = document.getElementById('formContainer');

        editFormButtons.forEach(button => {
            button.addEventListener('click', function() {
                const alunoId = this.getAttribute('data-id');
                const nomeAluno = this.getAttribute('data-nome');
                const turmaId = this.getAttribute('data-turma');
                const ativoAluno = this.getAttribute('data-ativo');

                document.getElementById('nomeAluno').value = nomeAluno;
                document.getElementById('ativo').value = ativoAluno;

                formContainer.classList.remove('hidden');
                const turmaSelect = document.getElementById('turma_nome');
                turmaSelect.value = turmaId;
                document.getElementById('editform').action = `/alunos/${alunoId}`;
            });
        });

        document.getElementById('cancelFormButton').addEventListener('click', function() {
            formContainer.classList.add('hidden');
        });
    </script>
</body>

</html>
