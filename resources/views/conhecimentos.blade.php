<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Áreas de Conhecimento</title>
    <!-- Adicionando o Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
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

        .inactive {
            background-color: #d1d5db;
            color: #6b7280;
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
            <h1 class="text-3xl mt-16 mb-12 font-bold">Área de Conhecimento</h1>
        </div>

        <div class="mr-4">
            <button id="openFormButton"
                class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar
                Área de Conhecimento</button>
        </div>
    </div>

    <div class="flex justify-center">
        <div class="w-full lg:w-2/3 px-4">
            @if ($conhecimentos->isEmpty())
                <p class="text-center text-gray-600">Nenhuma área de conhecimento cadastrada.</p>
            @else
                @foreach ($conhecimentos as $conhecimento)
                    <div class="turma-card {{ $conhecimento->ativo ? 'bg-blue-300' : 'inactive' }} rounded-md px-4 py-2 mb-4 flex items-center relative openViewFormButton cursor-pointer"
                        data-nome="{{ $conhecimento->nome_conhecimento }}"
                        data-descricao="{{ $conhecimento->descricao }}">
                        <p class="text-center cursor-pointer">{{ $conhecimento->nome_conhecimento }}</p>
                        <div class="flex items-center ml-auto">
                            <button class="openEditFormButton bi bi-pencil mx-3" data-id="{{ $conhecimento->id }}"
                                data-nome="{{ $conhecimento->nome_conhecimento }}"
                                data-descricao="{{ $conhecimento->descricao }}"></button>
                            @if ($conhecimento->ativo)
                                <form action="{{ route('conhecimentos.inativar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="conhecimento_id" value="{{ $conhecimento->id }}">
                                    <button type="submit"
                                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('conhecimentos.ativar', ['id' => $conhecimento->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="conhecimento_id" value="{{ $conhecimento->id }}">
                                    <button type="submit"
                                        class="bg-green-300 hover:bg-green-400 text-green-700 font-bold py-2 px-4 rounded">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Modal de Cadastro -->
    <div id="formContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <h2 class="text-2xl font-bold mb-4">Cadastrar Nova Área de Conhecimento</h2>
            <form id="form" action="{{ route('conhecimentos.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nomeConhecimento" class="block text-sm font-medium text-gray-700">Nome da Área*</label>
                    <input type="text" name="nome_conhecimento" id="nomeConhecimento"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                </div>
                <div class="mb-4">
                    <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição*</label>
                    <input type="text" name="descricao" id="descricao"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                </div>
                <div class="flex justify-between">
                    <button type="submit"
                        class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar</button>
                    <button type="button" id="cancelFormButton"
                        class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Edição -->
    <div id="editFormContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <h2 class="text-2xl font-bold mb-4">Editar Área de Conhecimento</h2>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="conhecimento_id" id="editConhecimentoId">
                <div class="mb-4">
                    <label for="editNomeConhecimento" class="block text-sm font-medium text-gray-700">Nome da
                        Área*</label>
                    <input type="text" name="nome_conhecimento" id="editNomeConhecimento"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="editDescricao" class="block text-sm font-medium text-gray-700">Descrição*</label>
                    <input type="text" name="descricao" id="editDescricao"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="flex justify-between">
                    <button type="submit"
                        class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Salvar
                        Alterações</button>
                    <button type="button" id="cancelEditFormButton"
                        class="bg-red-500 hover:bg-red-300 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-[#134196] text-white py-4 text-center mt-4 fixed bottom-0 w-full">
        <div class="container mx-auto">
            <p class="text-sm">&copy; {{ date('Y') }} Olimpíadas Científicas Colégio Londrinense. Todos os
                direitos reservados.</p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openFormButton = document.getElementById('openFormButton');
            const formContainer = document.getElementById('formContainer');
            const cancelFormButton = document.getElementById('cancelFormButton');

            const openEditFormButtons = document.querySelectorAll('.openEditFormButton');
            const editFormContainer = document.getElementById('editFormContainer');
            const cancelEditFormButton = document.getElementById('cancelEditFormButton');
            const editForm = document.getElementById('editForm');
            const editConhecimentoId = document.getElementById('editConhecimentoId');
            const editNomeConhecimento = document.getElementById('editNomeConhecimento');
            const editDescricao = document.getElementById('editDescricao');

            openFormButton.addEventListener('click', function() {
                formContainer.classList.remove('hidden');
            });

            cancelFormButton.addEventListener('click', function() {
                formContainer.classList.add('hidden');
            });

            openEditFormButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = button.getAttribute('data-id');
                    const nome = button.getAttribute('data-nome');
                    const descricao = button.getAttribute('data-descricao');

                    editConhecimentoId.value = id;
                    editNomeConhecimento.value = nome;
                    editDescricao.value = descricao;

                    editForm.setAttribute('action', `/conhecimentos/${id}`);
                    editFormContainer.classList.remove('hidden');
                });
            });

            cancelEditFormButton.addEventListener('click', function() {
                editFormContainer.classList.add('hidden');
            });
        });
    </script>
</body>

</html>
