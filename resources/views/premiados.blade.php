<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Premiados</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
</head>
<body class="bg-white">

  <!-- Cabeçalho -->
  <div class="header bg-[#134196] text-white py-4 text-center fixed w-full z-10 flex justify-between items-center px-4">
      <button id="menuToggle" class="text-white">
          <i class="bi bi-list"></i>
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

  <!-- Cards dos alunos premiados agrupados por Série e Turma -->
  @foreach($premiados as $serie => $premiadosSerie)
      <div class="text-center font-bold text-lg"><h2>{{ $serie }}ª Série</h2></div>
      @foreach($premiadosSerie->groupBy(function($premiado) { return $premiado->aluno->turma->nome_turma; }) as $nomeTurma => $premiadosTurma)
          <div class="ml-4 mb-8">
              <h3 class="text-xl font-semibold">{{ $nomeTurma }}</h3>
              @if($premiadosTurma->isEmpty())
                  <p class="text-gray-500">Nenhum premiado nesta turma.</p>
              @else
                  <div class="flex flex-wrap justify-center">
                      @foreach($premiadosTurma as $premiado)
                          <div class="flex justify-center mb-4 mr-4">
                              <div class="premio-card bg-{{ $premiado->medalha == 'ouro' ? 'yellow-400' : ($premiado->medalha == 'prata' ? 'gray-300' : 'brown-600') }} rounded-md px-4 py-2 flex items-center">
                                  <p class="text-center">{{ $premiado->aluno->nome }} - Medalha de {{ ucfirst($premiado->medalha) }}</p>
                                  <div class="flex items-center ml-4">
                                      <!-- Botão de editar -->
                                      <button type="button" class="hover:bg-blue-300 text-black hover:text-white btn btn-outline-primary me-2 px-5 openEditFormButton" data-id="{{ $premiado->id }}" data-aluno_id="{{ $premiado->aluno_id }}" data-medalha="{{ $premiado->medalha }}" data-olimpiada_id="{{ $premiado->olimpiada_id }}">
                                          <i class="bi bi-pencil"></i>
                                      </button>
                                      <!-- Botão de deletar -->
                                      <form action="{{ route('premiados.remover', $premiado->id) }}" method="POST" class="inline">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-outline-danger pr-5 hover:bg-red-500 text-black hover:text-white">
                                              <i class="bi bi-trash"></i>
                                          </button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                  </div>
              @endif
          </div>
      @endforeach
  @endforeach

  <!-- Formulário de cadastro de aluno premiado -->
  <div id="formContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
          <h2 class="text-2xl font-bold mb-4">Cadastrar Novo Premiado</h2>
          <form id="createForm" action="{{ route('premiados.store') }}" method="POST">
              @csrf
              <div class="mb-4">
                  <label for="aluno_id" class="block text-sm font-medium text-gray-700">Aluno</label>
                  <select name="aluno_id" id="aluno_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      <option value="">Selecione o aluno</option>
                      @foreach($alunos as $aluno)
                          <option value="{{ $aluno->id }}">{{ $aluno->nome }} ({{ $aluno->turma->nome_turma }})</option>
                      @endforeach
                  </select>
                  @error('aluno_id')
                      <span class="text-red-500 text-sm">{{ $message }}</span>
                  @enderror
              </div>
              <div class="mb-4">
                  <label for="medalha" class="block text-sm font-medium text-gray-700">Medalha</label>
                  <select name="medalha" id="medalha" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm">
                      <option value="">Selecione a medalha</option>
                      <option value="ouro">Ouro</option>
                      <option value="prata">Prata</option>
                      <option value="bronze">Bronze</option>
                  </select>
                  @error('medalha')
                      <span class="text-red-500 text-sm">{{ $message }}</span>
                  @enderror
              </div>
              <div class="mb-4">
                  <label for="olimpiada_id" class="block text-sm font-medium text-gray-700">Olimpíada</label>
                  <select name="olimpiada_id" id="olimpiada_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      <option value="">Selecione a olimpíada</option>
                      @foreach($olimpiadas as $olimpiada)
                          <option value="{{ $olimpiada->id }}">{{ $olimpiada->nome_olimpiada }}</option>
                      @endforeach
                  </select>
                  @error('olimpiada_id')
                      <span class="text-red-500 text-sm">{{ $message }}</span>
                  @enderror
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
              <div class="mb-4">
                  <label for="edit_aluno_id" class="block text-sm font-sans text-gray-700">Aluno</label>
                  <select name="aluno_id" id="aluno_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Selecione o aluno</option>
                    @foreach($alunos as $aluno)
                        <option value="{{ $aluno->id }}">{{ $aluno->nome }} ({{ $aluno->turma->nome_turma }})</option>
                    @endforeach
                </select>

                <select name="medalha" id="medalha" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Selecione a medalha</option>
                    <option value="ouro">Ouro</option>
                    <option value="prata">Prata</option>
                    <option value="bronze">Bronze</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Salvar alterações</button>
          </form>
      </div>
  </div>

  <!-- Script -->
  <script>
      // Abrir o formulário de cadastro
      document.getElementById('openFormButton').addEventListener('click', function() {
          document.getElementById('formContainer').classList.remove('hidden');
      });

      // Fechar o formulário de cadastro
      document.getElementById('cancelFormButton').addEventListener('click', function() {
          document.getElementById('formContainer').classList.add('hidden');
      });

      // Abrir o formulário de edição
      const openEditFormButtons = document.querySelectorAll('.openEditFormButton');
      openEditFormButtons.forEach(button => {
          button.addEventListener('click', function() {
              const premiadoId = button.dataset.id;
              const alunoId = button.dataset.aluno_id;
              const medalha = button.dataset.medalha;

              document.getElementById('edit_aluno_id').value = alunoId;
              document.getElementById('edit_medalha').value = medalha;

              document.getElementById('editForm').action = `/premiados/${premiadoId}/atualizar`;
              document.getElementById('editFormContainer').classList.remove('hidden');
          });
      });

      // Fechar o formulário de edição
      document.getElementById('cancelEditFormButton').addEventListener('click', function() {
          document.getElementById('editFormContainer').classList.add('hidden');
      });
  </script>

</body>
</html>
