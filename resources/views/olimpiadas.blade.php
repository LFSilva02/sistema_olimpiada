<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Olimpíadas</title>
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
    <div
        class="header bg-[#134196] text-white py-4 text-center fixed w-full z-10 flex justify-center items-center px-4">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('storage/img/colegiolondrinense.png') }}" alt="Logo" class="h-14">
            <h1 class="text-xl font-bold">Olimpíadas Científicas Colégio Londrinense</h1>
        </div>
    </div>

    @include('components.sidebar')

    <div class="ml-64 pt-20 mb-8 flex items-center justify-between">
        <div class="flex-1 text-center">
            <h1 class="text-3xl mt-16 mb-12 font-bold">Olimpíadas</h1>
        </div>

        <div class="mr-4">
            <button id="openFormButton"
                class="bg-[#134196] hover:bg-blue-300 text-white hover:text-black font-bold py-2 px-4 rounded">Cadastrar
                Olimpíadas</button>
        </div>
    </div>

    <!-- Lista de Olimpíadas -->
    <div class="flex justify-center">
        <div class="w-full lg:w-2/3 px-4">
            @foreach ($olimpiadas as $olimpiada)
                <div
                    class="olimpiada-card {{ $olimpiada->ativo ? 'bg-blue-300' : 'inactive' }} rounded-md px-4 py-2 mb-4 flex items-center relative">
                    <button type="button" class="focus:outline-none">
                        <p class="text-center cursor-pointer">{{ $olimpiada->nome_olimpiada }}</p>
                    </button>
                    <div class="flex items-center ml-auto">
                        {{-- botão para editar --}}
                        <button class="openEditFormButton bi bi-pencil mx-3" data-id="{{ $olimpiada->id }}"
                            data-nome="{{ $olimpiada->nome_olimpiada }}" data-data="{{ $olimpiada->data_olimpiada }}"
                            data-horario="{{ $olimpiada->horario }}" data-local="{{ $olimpiada->local }}"
                            data-sala="{{ $olimpiada->sala }}"></button>
                        {{-- botão para inativar/ativar --}}
                        @if ($olimpiada->ativo)
                            <form action="{{ route('olimpiadas.inativar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="olimpiada_id" value="{{ $olimpiada->id }}">
                                <button type="submit"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('olimpiadas.ativar', ['id' => $olimpiada->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="bg-green-300 hover:bg-green-400 text-green-700 font-bold py-2 px-4 rounded">
                                    <i class="bi bi-check"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Formulário para cadastrar Olimpíadas -->
    <div id="formContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2 relative">
            <h2 class="text-2xl font-bold mb-4">Cadastrar Nova Olimpíada</h2>
            <form id="form" action="{{ route('olimpiadas.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nomeOlimpiada" class="block text-sm font-medium text-gray-700">Nome da Olimpíada*</label>
                    <input type="text" name="nome_olimpiada" id="nomeOlimpiada"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"required>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="dataOlimpiada" class="block text-sm font-medium text-gray-700">Data da
                            Olimpíada*</label>
                        <input type="date" name="data_olimpiada" id="dataOlimpiada"
                            class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"required>
                    </div>
                    <div>
                        <label for="horario" class="block text-sm font-medium text-gray-700">Horário*</label>
                        <input type="time" name="horario" id="horario"
                            class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="local" class="block text-sm font-medium text-gray-700">Local*</label>
                        <input type="text" name="local" id="local"
                            class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"required>
                    </div>
                    <div>
                        <label for="sala" class="block text-sm font-medium text-gray-700">Sala*</label>
                        <input type="text" name="sala" id="sala"
                            class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"required>
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Salvar</button>
                    <button type="button" id="closeFormButton"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Formulário para editar Olimpíadas -->
    <div id="editFormContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2 relative">
            <h2 class="text-2xl font-bold mb-4">Editar Olimpíada</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="editNomeOlimpiada" class="block text-sm font-medium text-gray-700">Nome da
                        Olimpíada*</label>
                    <input type="text" name="nome_olimpiada" id="editNomeOlimpiada"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"required>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="editDataOlimpiada" class="block text-sm font-medium text-gray-700">Data da
                            Olimpíada*</label>
                        <input type="date" name="data_olimpiada" id="editDataOlimpiada"
                            class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"required>
                    </div>
                    <div>
                        <label for="editHorario" class="block text-sm font-medium text-gray-700">Horário*</label>
                        <input type="time" name="horario" id="editHorario"
                            class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="editLocal" class="block text-sm font-medium text-gray-700">Local*</label>
                        <input type="text" name="local" id="editLocal"
                            class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"required>
                    </div>
                    <div>
                        <label for="editSala" class="block text-sm font-medium text-gray-700">Sala*</label>
                        <input type="text" name="sala" id="editSala"
                            class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"required>
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Salvar</button>
                    <button type="button" id="closeEditFormButton"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancelar</button>
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
        document.getElementById('menuToggle').addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-hidden');
            sidebar.classList.toggle('sidebar-visible');
        });

        document.getElementById('openFormButton').addEventListener('click', function() {
            document.getElementById('formContainer').classList.remove('hidden');
        });

        document.getElementById('closeFormButton').addEventListener('click', function() {
            document.getElementById('formContainer').classList.add('hidden');
        });

        document.querySelectorAll('.openEditFormButton').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('editFormContainer').classList.remove('hidden');
                document.getElementById('editForm').action = "/olimpiadas/" + this.getAttribute('data-id');
                document.getElementById('editNomeOlimpiada').value = this.getAttribute('data-nome');
                document.getElementById('editDataOlimpiada').value = this.getAttribute('data-data');
                document.getElementById('editHorario').value = this.getAttribute('data-horario');
                document.getElementById('editLocal').value = this.getAttribute('data-local');
                document.getElementById('editSala').value = this.getAttribute('data-sala');
            });
        });

        document.getElementById('closeEditFormButton').addEventListener('click', function() {
            document.getElementById('editFormContainer').classList.add('hidden');
        });
    </script>
</body>

</html>
