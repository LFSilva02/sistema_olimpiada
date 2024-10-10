<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Premiados</title>
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
<div class="header bg-[#134196] text-white py-4 text-center fixed w-full z-10 flex justify-center items-center px-4">
    <div class="flex items-center space-x-4">
      <img src="{{ asset('storage/img/colegiolondrinense.png') }}" alt="Logo" class="h-14">
      <h1 class="text-xl font-bold">Olimpíadas Científicas Colégio Londrinense</h1>
    </div>
  </div>

@include('components.sidebar')

<div class="ml-64 pt-20 mb-8 flex items-center justify-between">
  <div class="flex-1 text-center">
    <h1 class="text-3xl mt-16 mb-12 font-bold">Premiados</h1>
  </div>
  <div class="mr-4">
    <button id="openFormButton" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar Premiado</button>
  </div>
</div>

<!-- Formulário para cadastrar premiado -->
<div id="formContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
  <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
    <h2 class="text-2xl font-bold mb-4">Cadastrar Novo Premiado</h2>
    <form id="form" action="{{ route('premiados.store') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="nomePremiado" class="block text-sm font-medium text-gray-700">Nome do Premiado</label>
        <input type="text" name="nomePremiado" id="nomePremiado" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
      </div>

      <!-- Campo para seleção da medalha -->
      <div class="mb-4">
        <label for="medalha" class="block text-sm font-medium text-gray-700">Medalha</label>
        <select name="medalha" id="medalha" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
          <option value="ouro">Ouro</option>
          <option value="prata">Prata</option>
          <option value="bronze">Bronze</option>
        </select>
      </div>

      <!-- Campo para selecionar a turma -->
      <div class="mb-4">
        <label for="turma_id" class="block text-sm font-medium text-gray-700">Turma</label>
        <select name="turma_id" id="turma_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
          @foreach($turmas as $turma)
            <option value="{{ $turma->id }}">{{ $turma->nome }}</option>
          @endforeach
        </select>
      </div>

      <!-- Campo para selecionar a olimpíada -->
      <div class="mb-4">
        <label for="olimpiada_id" class="block text-sm font-medium text-gray-700">Olimpíada</label>
        <select name="olimpiada_id" id="olimpiada_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
          @foreach($olimpiadas as $olimpiada)
            <option value="{{ $olimpiada->id }}">{{ $olimpiada->nome }}</option>
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
  document.getElementById('openFormButton').addEventListener('click', function() {
    document.getElementById('formContainer').classList.remove('hidden');
  });
  document.getElementById('cancelFormButton').addEventListener('click', function() {
    document.getElementById('formContainer').classList.add('hidden');
  });
</script>

</body>
</html>
