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
            <button id="openFormButton" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar Premiado</button>
        </div>
    </div>

    <!-- Formulário para cadastrar/editar premiado -->
    <div id="formContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <h2 id="formTitle" class="text-2xl font-bold mb-4">Cadastrar Novo Premiado</h2>

            <form id="form" action="{{ route('premiados.store') }}" method="POST">
                @csrf
                <input type="hidden" id="premiadoId" name="premiado_id" value="">

                <div class="mb-4">
                    <label for="aluno_id" class="block text-sm font-medium text-gray-700">Aluno</label>
                    <select name="aluno_id" id="aluno_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
                        @foreach ($alunos as $aluno)
                            <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="medalha" class="block text-sm font-medium text-gray-700">Medalha</label>
                    <select name="medalha" id="medalha" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
                        <option value="ouro">Ouro</option>
                        <option value="prata">Prata</option>
                        <option value="bronze">Bronze</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="olimpiada_id" class="block text-sm font-medium text-gray-700">Olimpíada</label>
                    <select name="olimpiada_id" id="olimpiada_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
                        @foreach ($olimpiadas as $olimpiada)
                            <option value="{{ $olimpiada->id }}">{{ $olimpiada->nome_olimpiada }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="ativo" class="block text-sm font-medium text-gray-700">Ativo</label>
                    <select name="ativo" id="ativo" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Salvar</button>
                    <button type="button" id="cancelFormButton" class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
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
                        <button class="openEditFormButton bi bi-pencil mx-3"
                            data-id="{{ $premiado->id }}"
                            data-aluno="{{ $premiado->aluno_id }}"
                            data-medalha="{{ $premiado->medalha }}"
                            data-olimpiada="{{ $premiado->olimpiada_id }}"
                            data-ativo="{{ $premiado->ativo }}">
                        </button>
                        @if ($premiado->ativo)
                        <form action="{{ route('premiados.inativar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="premiado_id" value="{{ $premiado->id }}">
                            <button type="submit" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @else
                        <form action="{{ route('premiados.ativar', ['id' => $premiado->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="bg-green-300 hover:bg-green-400 text-green-700 font-bold py-2 px-4 rounded">
                                <i class="bi bi-check"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Nenhum premiado encontrado</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        document.getElementById('openFormButton').addEventListener('click', function() {
            document.getElementById('formTitle').textContent = 'Cadastrar Novo Premiado';
            document.getElementById('premiadoId').value = '';
            document.getElementById('form').action = '{{ route("premiados.store") }}';
            document.getElementById('formContainer').classList.remove('hidden');
        });

        document.getElementById('cancelFormButton').addEventListener('click', function() {
            document.getElementById('formContainer').classList.add('hidden');
        });

        // Adicionando funcionalidade de edição
        const editButtons = document.querySelectorAll('.openEditFormButton');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const alunoId = this.dataset.aluno;
                const medalha = this.dataset.medalha;
                const olimpiadaId = this.dataset.olimpiada;
                const ativo = this.dataset.ativo;

                // Preenche o formulário com os dados do premiado
                document.getElementById('premiadoId').value = id;
                document.getElementById('aluno_id').value = alunoId;
                document.getElementById('medalha').value = medalha;
                document.getElementById('olimpiada_id').value = olimpiadaId;
                document.getElementById('ativo').value = ativo;

                // Muda o título do formulário
                document.getElementById('formTitle').textContent = 'Editar Premiado';

                // Altera a ação do formulário para o método de atualização
                document.getElementById('form').action = '{{ route("premiados.update", ":id") }}'.replace(':id', id);

                // Exibe o formulário
                document.getElementById('formContainer').classList.remove('hidden');
            });
        });
    </script>
</body>

</html>
