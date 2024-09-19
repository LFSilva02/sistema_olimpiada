<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Turmas</title>
  <!-- Adicionando o Tailwind CSS -->
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
      <h1 class="text-3xl mt-16 mb-12 font-bold">Turmas</h1>
    </div>

    <div class="mr-4">
      <button id="openFormButton" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar Turma</button>
    </div>
  </div>

  <!-- Card das turmas -->
  @foreach($turmas as $serie => $turmasSerie)
    <div class="text-center font-bold text-lg"><h2>{{ $serie }}ª Série</h2></div>
    <div class="flex flex-wrap justify-center">
        @foreach($turmasSerie as $turma)
            <div class="flex justify-center mb-4 mr-4">
                <div class="turma-card bg-{{ $turma->ativo ? 'blue-300' : 'gray-300' }} rounded-md px-4 py-2 flex items-center">
                    <p class="text-center cursor-pointer openStudentFormButton" data-turma-id="{{ $turma->id }}">{{ $turma->nome_turma }}</p>
                    <div class="flex items-center">
                        <button type="button" class="hover:bg-blue-300 text-black hover:text-white btn btn-outline-primary me-2 px-5 openEditFormButton" data-id="{{ $turma->id }}" data-nome="{{ $turma->nome_turma }}" data-serie="{{ $turma->serie }}" data-ano="{{ $turma->ano }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('turmas.inativar') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="turma_id" value="{{ $turma->id }}">
                            <button type="submit" class="btn btn-outline-danger pr-5 hover:bg-blue-300 text-black hover:text-white">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @if(!$turma->ativo)
                        <form action="{{ route('turmas.ativar', ['id' => $turma->id]) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-outline-success px-5">
                                Ativar
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
  @endforeach

  <!-- Formulário para cadastrar turmas -->
  <div id="formContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
      <h2 class="text-2xl font-bold mb-4">Cadastrar Nova Turma</h2>
      <form id="form" action="{{ route('turmas.store') }}" method="POST">
        @csrf
        <div class="mb-4">
          <label for="nomeTurma" class="block text-sm font-medium text-gray-700">Nome da Turma</label>
          <input type="text" name="nomeTurma" id="nomeTurma" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div class="mb-4">
          <label for="serie" class="block text-sm font-medium text-gray-700">Série</label>
          <input type="text" name="serie" id="serie" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div class="mb-4">
          <label for="ano" class="block text-sm font-medium text-gray-700">Ano</label>
          <input type="text" name="ano" id="ano" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div class="flex justify-between">
          <button type="submit" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar</button>
          <button type="button" id="cancelFormButton" class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Formulário para editar turmas -->
  <div id="editFormContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
      <h2 class="text-2xl font-bold mb-4">Editar Turma</h2>
      <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="turma_id" id="editTurmaId">
        <div class="mb-4">
            <label for="editNomeTurma" class="block text-sm font-medium text-gray-700">Nome da Turma</label>
            <input type="text" name="nomeTurma" id="editNomeTurma" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
          </div>
          <div class="mb-4">
            <label for="editSerie" class="block text-sm font-medium text-gray-700">Série</label>
            <input type="text" name="serie" id="editSerie" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
          </div>
          <div class="mb-4">
            <label for="editAno" class="block text-sm font-medium text-gray-700">Ano</label>
            <input type="text" name="ano" id="editAno" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
          </div>
          <div class="flex justify-between">
            <button type="submit" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Salvar</button>
            <button type="button" id="cancelEditFormButton" class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
          </div>
      </form>
    </div>
  </div>
<!-- Footer -->
    <footer class="bg-[#134196] text-white py-4 text-center mt-4 fixed bottom-0 w-full">
        <div class="container mx-auto">
            <p class="text-sm">&copy; {{ date('Y') }} Olimpíadas Científicas Colégio Londrinense. Todos os direitos reservados.</p>
        </div>
    </footer>

  <script>
    // Função para alternar a visibilidade do formulário de cadastro de turma
    document.getElementById('openFormButton').addEventListener('click', function() {
      document.getElementById('formContainer').classList.remove('hidden');
    });
    document.getElementById('cancelFormButton').addEventListener('click', function() {
      document.getElementById('formContainer').classList.add('hidden');
    });

    // Função para alternar a visibilidade do formulário de edição de turma
    document.querySelectorAll('.openEditFormButton').forEach(function(button) {
      button.addEventListener('click', function() {
        document.getElementById('editFormContainer').classList.remove('hidden');
        document.getElementById('editTurmaId').value = this.getAttribute('data-id');
        document.getElementById('editNomeTurma').value = this.getAttribute('data-nome');
        document.getElementById('editSerie').value = this.getAttribute('data-serie');
        document.getElementById('editAno').value = this.getAttribute('data-ano');
        document.getElementById('editForm').action = '/turmas/' + this.getAttribute('data-id');
      });
    });
    document.getElementById('cancelEditFormButton').addEventListener('click', function() {
      document.getElementById('editFormContainer').classList.add('hidden');
    });

    // Função para alternar a visibilidade do menu lateral
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.querySelector('.sidebar');
    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('sidebar-hidden');
        sidebar.classList.toggle('sidebar-visible');
    });
  </script>
</body>
</html>
