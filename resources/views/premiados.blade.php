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
            <button id="openFormButton"
                class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar
                Premiado</button>
        </div>
    </div>

    <div id="formContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <h2 id="formTitle" class="text-2xl font-bold mb-4">Cadastrar Novo Premiado</h2>

            <form id="form" action="{{ route('premiados.store') }}" method="POST">
                @csrf
                <input type="hidden" id="premiadoId" name="premiado_id" value="">
                <div class="mb-4">
                    <label for="serie" class="block text-sm font-medium text-gray-700">Série</label>
                    <select name="serie" id="serie"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Selecione a Série</option>
                        <option value="1">1ª Série</option>
                        <option value="2">2ª Série</option>
                        <option value="3">3ª Série</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="turma" class="block text-sm font-medium text-gray-700">Turma</label>
                    <select name="turma_id" id="turma"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Selecione uma Turma</option>
                    </select>
                </div>
                <select name="aluno_id" id="aluno_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md"
                    required>
                    <option value="">Selecione um Aluno</option>
                </select>

                <div class="mb-4">
                    <label for="medalha" class="block text-sm font-medium text-gray-700">Medalha</label>
                    <select name="medalha" id="medalha"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
                        <option value="ouro">Ouro</option>
                        <option value="prata">Prata</option>
                        <option value="bronze">Bronze</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="olimpiada_id" class="block text-sm font-medium text-gray-700">Olimpíada</label>
                    <select name="olimpiada_id" id="olimpiada_id"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
                        @foreach ($olimpiadas as $olimpiada)
                            <option value="{{ $olimpiada->id }}">{{ $olimpiada->nome_olimpiada }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="ativo" class="block text-sm font-medium text-gray-700">Ativo</label>
                    <select name="ativo" id="ativo"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>

                <div class="flex justify-between">
                    <button type="submit"
                        class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Salvar</button>
                    <button type="button" id="cancelFormButton"
                        class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <table class="min-w-full bg-white border rounded-md">
        <thead>
            <tr>
                <th class="border px-4 py-2 text-left">Nome</th>
                <th class="border px-4 py-2 text-left">Olimpíada</th>
                <th class="border px-4 py-2 text-left">Medalha</th>
                <th class="border px-4 py-2 text-left">Ações</th>
            </tr>
        </thead>
        <tbody id="studentList">
            @forelse ($premiados as $premiado)
                <tr>
                    <td>{{ $premiado->aluno->nome }}</td>
                    <td>{{ $premiado->olimpiada->nome_olimpiada }}</td>
                    <td>{{ $premiado->medalha }}</td>
                    <td>
                        <div class="flex items-center ml-auto">
                            <button class="openEditFormButton bi bi-pencil mx-3" data-id="{{ $premiado->id }}"
                                data-aluno="{{ $premiado->aluno_id }}" data-medalha="{{ $premiado->medalha }}"
                                data-olimpiada="{{ $premiado->olimpiada_id }}" data-turma="{{ $premiado->turma_id }}"
                                data-serie="{{ $premiado->serie }}" data-ativo="{{ $premiado->ativo }}">
                            </button>
                            @if ($premiado->ativo)
                                <form action="{{ route('premiados.inativar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="premiado_id" value="{{ $premiado->id }}">
                                    <button type="submit"
                                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('premiados.ativar', ['id' => $premiado->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="bg-green-300 hover:bg-green-400 text-green-700 font-bold py-2 px-4 rounded">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhum premiado cadastrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Footer -->
    <footer class="bg-[#134196] text-white py-4 text-center mt-4 fixed bottom-0 w-full">
        <div class="container mx-auto">
            <p class="text-sm">&copy; {{ date('Y') }} Olimpíadas Científicas Colégio Londrinense. Todos os
                direitos reservados.</p>
        </div>
    </footer>
    <script>
        // Exibir o formulário para cadastrar novo premiado
        document.getElementById('openFormButton').addEventListener('click', function() {
            document.getElementById('formTitle').textContent = 'Cadastrar Novo Premiado';
            document.getElementById('premiadoId').value = '';
            document.getElementById('form').reset();
            document.getElementById('form').action = "{{ route('premiados.store') }}";
            document.getElementById('formContainer').classList.remove('hidden');
        });

        // Cancelar e esconder o formulário
        document.getElementById('cancelFormButton').addEventListener('click', function() {
            document.getElementById('formContainer').classList.add('hidden');
        });

        // Manipulador de eventos para carregar informações no formulário de edição
        document.querySelectorAll('.openEditFormButton').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('formTitle').textContent = 'Editar Premiado';
                document.getElementById('premiadoId').value = button.dataset.id;

                // Preencher os campos com os dados do premiado
                document.getElementById('aluno_id').value = button.dataset.aluno;
                document.getElementById('medalha').value = button.dataset.medalha;
                document.getElementById('olimpiada_id').value = button.dataset.olimpiada;
                document.getElementById('turma').value = button.dataset.turma;
                document.getElementById('serie').value = button.dataset.serie;
                document.getElementById('ativo').value = button.dataset.ativo;

                // Definir a ação do formulário para o endpoint de atualização com o ID do premiado
                document.getElementById('form').action = "{{ url('premiados') }}/" + button.dataset.id;
                document.getElementById('formContainer').classList.remove('hidden');
            });
        });

        // Carregar turmas com base na série selecionada
        document.getElementById('serie').addEventListener('change', function() {
            const serie = encodeURIComponent(this.value);
            if (serie) {
                fetch(`/turmas/serie/${serie}`)
                    .then(response => response.ok ? response.json() : Promise.reject(response))
                    .then(turmas => {
                        const turmaSelect = document.getElementById('turma');
                        turmaSelect.innerHTML = '<option value="">Selecione uma Turma</option>';
                        turmas.forEach(turma => {
                            const option = document.createElement('option');
                            option.value = turma.id;
                            option.textContent = turma.nome_turma;
                            turmaSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Erro ao carregar turmas:', error));
            } else {
                document.getElementById('turma').innerHTML = '<option value="">Selecione uma Turma</option>';
            }
        });

        // Carregar alunos com base na turma selecionada
        document.getElementById('turma').addEventListener('change', function() {
            const turmaId = this.value;
            if (turmaId) {
                fetch(`/alunos/turma/${turmaId}`)
                    .then(response => response.ok ? response.json() : Promise.reject(response))
                    .then(alunos => {
                        const alunoSelect = document.getElementById('aluno_id');
                        alunoSelect.innerHTML = '<option value="">Selecione um Aluno</option>';
                        alunos.forEach(aluno => {
                            const option = document.createElement('option');
                            option.value = aluno.id;
                            option.textContent = aluno.nome;
                            alunoSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Erro ao carregar alunos:', error));
            } else {
                document.getElementById('aluno_id').innerHTML = '<option value="">Selecione um Aluno</option>';
            }
        });
    </script>

</body>

</html>
