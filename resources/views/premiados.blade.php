<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Premiados</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .sidebar-hidden { transform: translateX(-100%); }
    .sidebar-visible { transform: translateX(0); }
    .transition-transform { transition: transform 0.3s ease-in-out; }
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

@foreach($premiados as $categoria => $premiadosCategoria)
  <div class="text-center font-bold text-lg"><h2>{{ $categoria }}</h2></div>
  <div class="flex flex-wrap justify-center">
    @foreach($premiadosCategoria as $premiado)
      <div class="flex justify-center mb-4 mr-4">
        <div class="premiado-card bg-{{ $premiado->ativo ? 'blue-300' : 'gray-300' }} rounded-md px-4 py-2 flex items-center">
          <p class="text-center cursor-pointer">{{ $premiado->nome }}</p>
          <div class="flex items-center">
            <button type="button" class="hover:bg-blue-300 text-black hover:text-white btn btn-outline-primary me-2 px-5 openEditFormButton" data-id="{{ $premiado->id }}" data-nome="{{ $premiado->nome }}" data-categoria="{{ $premiado->categoria }}">
              <i class="bi bi-pencil"></i>
            </button>
            <form action="{{ route('premiados.inativar') }}" method="POST" class="inline">
              @csrf
              <input type="hidden" name="premiado_id" value="{{ $premiado->id }}">
              <button type="submit" class="btn btn-outline-danger pr-5 hover:bg-blue-300 text-black hover:text-white">
                <i class="bi bi-trash"></i>
              </button>
            </form>
            @if(!$premiado->ativo)
              <form action="{{ route('premiados.ativar', ['id' => $premiado->id]) }}" method="POST" class="inline">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-outline-success px-5">Ativar</button>
              </form>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endforeach

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
      <div class="mb-4">
        <label for="categoria" class="block text-sm font-medium text-gray-700">Categoria</label>
        <input type="text" name="categoria" id="categoria" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
      </div>
      <div class="flex justify-between">
        <button type="submit" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar</button>
        <button type="button" id="cancelFormButton" class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<!-- Formulário para editar premiado -->
<div id="editFormContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
  <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
    <h2 class="text-2xl font-bold mb-4">Editar Premiado</h2>
    <form id="editForm" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" name="premiado_id" id="editPremiadoId">
      <div class="mb-4">
        <label for="editNomePremiado" class="block text-sm font-medium text-gray-700">Nome do Premiado</label>
        <input type="text" name="nomePremiado" id="editNomePremiado" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
      </div>
      <div class="mb-4">
        <label for="editCategoria" class="block text-sm font-medium text-gray-700">Categoria</label>
        <input type="text" name="categoria" id="editCategoria" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
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
      document.getElementById('editFormContainer').classList.remove('hidden');
      document.getElementById('editPremiadoId').value = this.getAttribute('data-id');
      document.getElementById('editNomePremiado').value = this.getAttribute('data-nome');
      document.getElementById('editCategoria').value = this.getAttribute('data-categoria');
      document.getElementById('editForm').action = '/premiados/' + this.getAttribute('data-id');
    });
  });

  document.getElementById('cancelEditFormButton').addEventListener('click', function() {
    document.getElementById('editFormContainer').classList.add('hidden');
  });
</script>

</body>
</html>
