<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
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

    <div class="ml-64 pt-20 mb-8 flex items-center justify-between">
        <div class="flex-1 text-center">
            <h1 class="text-3xl mt-16 mb-12 font-bold">Alunos</h1>
        </div>

        <div class="mr-4">
            <button id="openFormButton" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">
                Cadastrar Aluno
            </button>
        </div>
    </div>

    <!-- Listagem de Turmas com Scroll Horizontal e Centralização -->
    <div class="container mx-auto px-4">
        <div class="overflow-x-auto whitespace-nowrap flex justify-center space-x-36">
            @foreach ($turmas->groupBy('serie') as $serie => $turmasPorSerie)
                <div class="inline-block text-center">
                    <h2 class="text-2xl font-bold mb-4">Série: {{ $serie }}</h2>
                    @foreach ($turmasPorSerie as $turma)
                        <div>
                            <h3 class="text-xl font-semibold mb-2 cursor-pointer text-blue-500 hover:underline"
                                onclick="checkTurma('{{ $turma->id }}', {{ $turma->alunos->count() }})">
                                Turma: {{ $turma->nome_turma }}
                            </h3>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <!--Botão Ativar/Inativar -->
    @if ($aluno->ativo)
    <form action="{{ route('alunos.inativar') }}" method="POST" class="inline-block">
        @csrf
        <input type="hidden" name="aluno_id" value="{{ $aluno->id }}">
        <button type="submit"
            class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded">
            Inativar
        </button>
    </form>
    @else

    <!-- Formulário para cadastrar alunos -->
    <div id="formContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <h2 class="text-2xl font-bold mb-4">Cadastrar Novo Aluno</h2>
            <form id="form" action="{{ route('alunos.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nomeAluno" class="block text-sm font-medium text-gray-700">Nome do Aluno*</label>
                    <input type="text" name="nome" id="nomeAluno" required
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="turma_id" class="block text-sm font-medium text-gray-700">Turma*</label>
                    <select name="turma_id" id="turma_id" required
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach ($turmas as $turma)
                            <option value="{{ $turma->id }}">{{ $turma->nome_turma }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between">
                    <button type="submit"
                        class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar</button>
                    <button type="button" id="cancelFormButton"
                        class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mensagem de Turma Vazia -->
    <div id="emptyMessage" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="relative bg-white p-8 rounded-lg shadow-lg w-1/3 text-center">
            <!-- Botão de Fechar (X) -->
            <button id="closeEmptyMessageButton" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 font-bold text-2xl">&times;</button>

            <!-- Conteúdo do Modal -->
            <h2 class="text-xl font-bold mb-4">Nenhum aluno cadastrado nesta turma</h2>
            <button id="addStudentButton" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar Aluno</button>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-[#134196] text-white py-4 text-center mt-4 fixed bottom-0 w-full">
        <div class="container mx-auto">
            <p class="text-sm">&copy; {{ date('Y') }} Olimpíadas Científicas Colégio Londrinense. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // Abrir formulário ao clicar no botão "Cadastrar Aluno"
        document.getElementById('openFormButton').addEventListener('click', function() {
            document.getElementById('formContainer').classList.remove('hidden');
        });

        // Cancelar formulário ao clicar em "Cancelar"
        document.getElementById('cancelFormButton').addEventListener('click', function() {
            document.getElementById('formContainer').classList.add('hidden');
        });

        // Verificar turma ao clicar e mostrar formulário se estiver vazia
        function checkTurma(turmaId, alunoCount) {
            if (alunoCount === 0) {
                document.getElementById('emptyMessage').classList.remove('hidden');

                // Exibir formulário ao clicar em "Cadastrar Aluno" no modal
                document.getElementById('addStudentButton').onclick = function() {
                    document.getElementById('emptyMessage').classList.add('hidden');
                    document.getElementById('formContainer').classList.remove('hidden');
                };

                // Fechar modal ao clicar no "X"
                document.getElementById('closeEmptyMessageButton').onclick = function() {
                    document.getElementById('emptyMessage').classList.add('hidden');
                };
            } else {
                window.location = `/turmas/${turmaId}/alunos`;
            }
        }
    </script>
</body>

</html>
