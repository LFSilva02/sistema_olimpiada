<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Premiados</title>
  <!-- Adicionando o Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
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

<!-- Título e botão de cadastro -->
<div class="ml-64 pt-20 mb-8 flex items-center justify-between">
    <div class="flex-1 text-center">
        <h1 class="text-3xl mt-16 mb-12 font-bold">Premiados</h1>
    </div>
    <div class="mr-4">
        <button id="openFormButton" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar Premiado</button>
    </div>
</div>

<!-- Cards dos alunos premiados -->
@foreach($premiados as $olimpiada => $alunos)
    <div class="text-center font-bold text-lg"><h2>{{ $olimpiada }}</h2></div>
    <div class="flex flex-wrap justify-center">
        @foreach($alunos as $aluno)
            <div class="flex justify-center mb-4 mr-4">
                <div class="premio-card bg-{{ $aluno->medalha == 'ouro' ? 'yellow-400' : ($aluno->medalha == 'prata' ? 'gray-300' : 'bronze-600') }} rounded-md px-4 py-2 flex items-center">
                    <p class="text-center">{{ $aluno->nome }} - Medalha de {{ ucfirst($aluno->medalha) }}</p>
                    <div class="flex items-center ml-4">
                        <!-- Botão de editar -->
                        <button type="button" class="hover:bg-blue-300 text-black hover:text-white btn btn-outline-primary me-2 px-5 openEditFormButton" data-id="{{ $aluno->id }}" data-nome="{{ $aluno->nome }}" data-medalha="{{ $aluno->medalha }}" data-olimpiada="{{ $aluno->olimpiada }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <!-- Botão de deletar -->
                        <form action="{{ route('premiados.remover', $aluno->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger pr-5 hover:bg-blue-300 text-black hover:text-white">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach

<!-- Formulário de cadastro de aluno premiado -->
<div id="formContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
        <h2 class="text-2xl font-bold mb-4">Cadastrar Novo Premiado</h2>
        <form id="form" action="{{ route('premiados.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="aluno_id" class="block text-sm font-medium text-gray-700">Aluno</label>
                <select name="aluno_id" id="aluno_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach($alunos as $aluno)
                        <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="medalha" class="block text-sm font-medium text-gray-700">Medalha</label>
                <select name="medalha" id="medalha" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm">
                    <option value="ouro">Ouro</option>
                    <option value="prata">Prata</option>
                    <option value="bronze">Bronze</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="olimpiada_id" class="block text-sm font-medium text-gray-700">Olimpíada</label>
                <select name="olimpiada_id" id="olimpiada_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach($olimpiadas as $olimpiada)
                        <option value="{{ $olimpiada->id }}">{{ $olimpiada->nome_olimpiada }}</option>
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

<script>
    // Abrir e fechar formulário de cadastro
    const openFormButton = document.getElementById('openFormButton');
    const formContainer = document.getElementById('formContainer');
    const cancelFormButton = document.getElementById('cancelFormButton');

    openFormButton.addEventListener('click', () => {
        formContainer.classList.remove('hidden');
    });

    cancelFormButton.addEventListener('click', () => {
        formContainer.classList.add('hidden');
    });

    // Abrir formulário de edição com dados do aluno
    const editFormButtons = document.querySelectorAll('.openEditFormButton');
    editFormButtons.forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const nome = button.dataset.nome;
            const medalha = button.dataset.medalha;
            const olimpiada = button.dataset.olimpiada;

            // Ajusta os campos do formulário para edição
            const form = document.getElementById('form');
            form.action = `/premiados/editar/${id}`;
            document.getElementById('nomeAluno').value = nome;
            document.getElementById('medalha').value = medalha;
            document.getElementById('olimpiada').value = olimpiada;
            formContainer.classList.remove('hidden');
        });
    });
</script>
</body>
</html>
