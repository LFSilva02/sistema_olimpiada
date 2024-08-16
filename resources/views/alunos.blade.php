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

    <div class="header bg-[#134196] text-white py-4 text-center fixed w-full z-10 flex justify-between items-center px-4">
        <div>
            <button id="menuToggle" class="text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <div class="flex items-center space-x-4">
            <img src="{{ asset('storage/img/colegiolondrinense.png') }}" alt="Logo" class="h-14">
            <h1 class="text-xl font-bold">Olimpíadas Científicas Colégio Londrinense</h1>
        </div>
        <div></div>
    </div>

    @include('components.sidebar') <!-- Certifique-se de que o sidebar tem a classe 'hidden' inicialmente -->

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
                    <input type="text" name="nomeAluno" id="nomeAluno" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="turma_id" class="block text-sm font-medium text-gray-700">Turma</label>
                    <select name="turma_id" id="turma_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach($turmas as $turma)
                            <option value="{{ $turma->id }}">{{ $turma->nome_turma }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between">
                    <button type="submit" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar</button>
                    <button type="button" id="cancelFormButton" class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Formulário para editar alunos -->
    <div id="editFormContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <h2 class="text-2xl font-bold mb-4">Editar Aluno</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="aluno_id" id="editAlunoId">
                <div class="mb-4">
                    <label for="editNomeAluno" class="block text-sm font-medium text-gray-700">Nome do Aluno</label>
                    <input type="text" name="nome" id="editNomeAluno" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="editTurmaId" class="block text-sm font-medium text-gray-700">Turma</label>
                    <select name="turma_id" id="editTurmaId" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach($turmas as $turma)
                            <option value="{{ $turma->id }}">{{ $turma->nome_turma }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between">
                    <button type="submit" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Salvar Alterações</button>
                    <button type="button" id="cancelEditFormButton" class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
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
    <!-- Footer -->
        <footer class="bg-[#134196] text-white py-4 text-center mt-4 fixed bottom-0 w-full">
        <div class="container mx-auto">
        <p class="text-sm">&copy; {{ date('Y') }} Olimpíadas Científicas Colégio Londrinense. Todos os direitos reservados.</p>
        </div>
        </footer>

    <script>
        document.getElementById('menuToggle').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('sidebar-hidden');
            document.getElementById('sidebar').classList.toggle('sidebar-visible');
        });

        document.getElementById('openFormButton').addEventListener('click', () => {
            document.getElementById('formContainer').classList.remove('hidden');
        });

        document.getElementById('cancelFormButton').addEventListener('click', () => {
            document.getElementById('formContainer').classList.add('hidden');
        });

        document.getElementById('cancelEditFormButton').addEventListener('click', () => {
            document.getElementById('editFormContainer').classList.add('hidden');
        });

        document.getElementById('closeTurmaPopup').addEventListener('click', () => {
            document.getElementById('turmaPopup').classList.add('hidden');
        });

        function openTurmaPopup(turmaId) {
            fetch(`/turma/${turmaId}/alunos`)
                .then(response => response.json())
                .then(data => {
                    const listaAlunos = data.alunos.map(aluno => `
                        <div class="flex justify-between items-center mb-2">
                            <span>${aluno.nome}</span>
                            <button class="bg-blue-500 hover:bg-blue-300 text-white font-bold py-1 px-2 rounded" onclick="editAluno(${aluno.id})">Editar</button>
                            <button class="bg-red-500 hover:bg-red-300 text-white font-bold py-1 px-2 rounded" onclick="deleteAluno(${aluno.id})">Excluir</button>
                        </div>
                    `).join('');
                    document.getElementById('turmaAlunosList').innerHTML = listaAlunos;
                    document.getElementById('turmaPopup').classList.remove('hidden');
                })
                .catch(error => console.error('Erro ao carregar alunos:', error));
        }

        function editAluno(alunoId) {
            fetch(`/aluno/${alunoId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editAlunoId').value = data.id;
                    document.getElementById('editNomeAluno').value = data.nome;
                    document.getElementById('editTurmaId').value = data.turma_id;
                    document.getElementById('editFormContainer').classList.remove('hidden');
                })
                .catch(error => console.error('Erro ao carregar aluno para edição:', error));
        }

        function deleteAluno(alunoId) {
            if (confirm('Tem certeza que deseja excluir este aluno?')) {
                fetch(`/aluno/${alunoId}`, { method: 'DELETE' })
                    .then(response => {
                        if (response.ok) {
                            alert('Aluno excluído com sucesso!');
                            location.reload(); // Recarrega a página para atualizar a lista
                        } else {
                            alert('Erro ao excluir aluno.');
                        }
                    })
                    .catch(error => console.error('Erro ao excluir aluno:', error));
            }
        }
    </script>
</body>
</html>
