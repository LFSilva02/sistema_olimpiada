<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
    </style>
</head>
<body class="bg-white">

<!-- Cabeçalho -->
<div class="header bg-[#134196] text-white py-4 text-center fixed w-full z-10 flex justify-between items-center px-4">
    <button id="menuToggle" class="text-white">
    </button>
    <div class="flex items-center space-x-4">
        <img src="{{ asset('storage/img/colegiolondrinense.png')}}" alt="Logo" class="h-14">
        <h1 class="text-xl font-bold">Olimpíadas Científicas Colégio Londrinense</h1>
      </div>
      <div></div>
    </div>
    @include('components.sidebar')

    <div class="ml-64 pt-20 mb-8 flex items-center justify-between">
        <div class="flex-1 text-center">
            <h1 class="text-3xl mt-16 mb-12 font-bold">Alunos</h1>
        </div>
        <div class="mr-4">
            <button id="openFormButton" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar Aluno</button>
        </div>
    </div>

    <div class="container mx-auto px-4">
        @foreach($turmas->groupBy('serie') as $serie => $turmasPorSerie)
            <h2 class="text-2xl font-bold my-4">Série: {{ $serie }}</h2>
            @foreach($turmasPorSerie as $turma)
                <h3 class="text-xl font-semibold mt-4 mb-2 cursor-pointer text-blue-500 hover:underline" onclick="openTurmaPopup({{ $turma->id }})">Turma: {{ $turma->nome_turma }}</h3>
            @endforeach
        @endforeach
    </div>

    <!-- Formulário para cadastrar alunos -->
    <div id="formContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <h2 class="text-2xl font-bold mb-4">Cadastrar Novo Aluno</h2>
            <form id="form" action="{{ route('alunos.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nomeAluno" class="block text-sm font-medium text-gray-700">Nome do Aluno</label>
                    <input type="text" name="nome" id="nomeAluno" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="turma_id" class="block text-sm font-medium text-gray-700">Turma</label>
                    <select name="turma_id" id="turma_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach($turmas as $turma)
                            <option value="{{ $turma->id }}">{{ $turma->nome_turma }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="ativo" class="block text-sm font-medium text-gray-700">Ativo</label>
                    <select name="ativo" id="ativo" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="flex justify-between">
                    <button type="submit" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar</button>
                    <button type="button" id="cancelFormButton" class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Pop-up com alunos da turma -->
    <div id="turmaPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <h2 class="text-2xl font-bold mb-4">Alunos da Turma</h2>
            <div id="turmaAlunosList"></div>
            <button id="closeTurmaPopup" class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Fechar</button>
        </div>
    </div>

    <footer class="bg-[#134196] text-white py-4 text-center mt-4 fixed bottom-0 w-full">
        <div class="container mx-auto">
            <p class="text-sm">&copy; {{ date('Y') }} Olimpíadas Científicas Colégio Londrinense. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        document.getElementById('menuToggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('sidebar-hidden');
            sidebar.classList.toggle('sidebar-visible');
        });

        document.getElementById('openFormButton').addEventListener('click', function() {
            document.getElementById('formContainer').classList.remove('hidden');
        });

        document.getElementById('cancelFormButton').addEventListener('click', function() {
            document.getElementById('formContainer').classList.add('hidden');
        });

        function openTurmaPopup(turmaId) {
            fetch(`/turma/${turmaId}/alunos`)
                .then(response => response.json())
                .then(data => {
                    const list = document.getElementById('turmaAlunosList');
                    list.innerHTML = '';
                    data.alunos.forEach(aluno => {
                        const item = document.createElement('div');
                        item.className = 'border-b border-gray-200 py-2';
                        item.innerHTML = `
                            <div class="flex justify-between items-center">
                                <span>${aluno.nome}</span>
                                <div>
                                    <button class="bg-yellow-500 hover:bg-yellow-300 text-white font-bold py-1 px-2 rounded mr-2" onclick="editAluno(${aluno.id})">Editar</button>
                                    <form action="/alunos/${aluno.id}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-300 text-white font-bold py-1 px-2 rounded">Deletar</button>
                                    </form>
                                </div>
                            </div>
                        `;
                        list.appendChild(item);
                    });
                    document.getElementById('turmaPopup').classList.remove('hidden');
                })
                .catch(error => console.error('Erro ao carregar alunos:', error));
        }

        document.getElementById('closeTurmaPopup').addEventListener('click', function() {
            document.getElementById('turmaPopup').classList.add('hidden');
        });
    </script>
</body>
</html>
