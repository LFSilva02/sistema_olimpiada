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

  @include('components.sidebar')

  <div class="ml-64 pt-20 mb-8 flex items-center justify-between">
    <div class="flex-1 text-center">
      <h1 class="text-3xl mt-16 mb-12 font-bold">Alunos</h1>
    </div>
    <div class="mr-4">
      <button id="openFormButton" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar Aluno</button>
    </div>
  </div>

  <!-- Card dos alunos -->
  <div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Lista de Alunos</h1>
    <table class="min-w-full bg-white">
      <thead>
        <tr>
          <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left">#</th>
          <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left">Nome</th>
          <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left">Turma</th>
          <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left">Status</th>
          <th class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left">Ações</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        @foreach($alunos as $aluno)
        <tr class="{{ $aluno->status == 'inativo' ? 'bg-gray-300 text-gray-500' : '' }}">
          <td>{{ $loop->iteration }}</td>
          <td>{{ $aluno->nome }}</td>
          <td>{{ $aluno->turma->nome }}</td>
          <td>{{ $aluno->status }}</td>
          <td>
            @if($aluno->status == 'ativo')
            <form action="{{ route('alunos.inativar') }}" method="POST">
              @csrf
              <input type="hidden" name="aluno_id" value="{{ $aluno->id }}">
              <button type="submit" class="text-red-500 hover:text-red-700">Inativar</button>
            </form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
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
          <input type="text" name="nomeAluno" id="editNomeAluno" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
          <button type="submit" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Salvar</button>
          <button type="button" id="cancelEditFormButton" class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.getElementById('openFormButton').addEventListener('click', function() {
      document.getElementById('formContainer').classList.remove('hidden');
    });

    document.getElementById('cancelFormButton').addEventListener('click', function() {
      document.getElementById('formContainer').classList.add('hidden');
    });

    document.querySelectorAll('.openEditFormButton').forEach(function(button) {
      button.addEventListener('click', function() {
        const alunoId = button.getAttribute('data-id');
        const alunoNome = button.getAttribute('data-nome');
        const turmaId = button.getAttribute('data-turma-id');

        document.getElementById('editAlunoId').value = alunoId;
        document.getElementById('editNomeAluno').value = alunoNome;
        document.getElementById('editTurmaId').value = turmaId;

        document.getElementById('editFormContainer').classList.remove('hidden');
      });
    });

    document.getElementById('cancelEditFormButton').addEventListener('click', function() {
      document.getElementById('editFormContainer').classList.add('hidden');
    });

    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    menuToggle.addEventListener('click', function() {
      sidebar.classList.toggle('sidebar-hidden');
      sidebar.classList.toggle('sidebar-visible');
    });
  </script>
</body>
</html>
