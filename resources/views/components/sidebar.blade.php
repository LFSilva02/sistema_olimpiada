<!-- Botão para abrir o sidebar -->
<button id="openSidebar" class="text-black fixed top-4 left-4 z-20">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
    </svg>
</button>

<!-- Sidebar -->
<div id="sidebar" class="sidebar z-10 bg-blue-300 text-white fixed top-0 left-0 h-screen w-64 transition-transform transform -translate-x-full">
    <div class="flex justify-end p-4">
        <button id="closeSidebar" class="text-black">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <div class="sidebar-item mt-20 py-2 px-4 hover:bg-blue-400 mb-7">
        <a href="#" class="text-black">Próximas Olimpíadas</a>
    </div>
    <div class="sidebar-item py-2 px-4 hover:bg-blue-400 mb-10">
        <a href="{{ route('conhecimentos.index') }}" class="text-black">Áreas de conhecimento</a>
    </div>
    <div class="sidebar-item py-2 px-4 hover:bg-blue-400 mb-10">
        <a href="{{ route('premiados.index') }}" class="text-black">Premiados</a>
    </div>
    <div class="sidebar-item py-2 px-4 hover:bg-blue-400 mb-10">
        <a href="{{ route('turmas.index') }}" class="text-black">Turmas</a>
    </div>
    <div class="sidebar-item py-2 px-4 hover:bg-blue-400 mb-10">
        <a href="{{ route('olimpiadas.index') }}" class="text-black">Olimpíadas</a>
    </div>
    <div class="sidebar-item py-2 px-4 hover:bg-blue-400 mb-10">
        <a href="{{ route('alunos.index') }}" class="text-black">Alunos</a>
    </div>
</div>

<!-- Script para manipulação do sidebar -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const closeSidebarButton = document.getElementById('closeSidebar');
        const openSidebarButton = document.getElementById('openSidebar');

        // Função para abrir o sidebar
        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
        }

        // Função para fechar o sidebar
        function closeSidebar() {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
        }

        // Evento para fechar o sidebar ao clicar no botão
        closeSidebarButton.addEventListener('click', function () {
            closeSidebar();
        });

        // Evento para abrir o sidebar ao clicar no botão
        openSidebarButton.addEventListener('click', function () {
            openSidebar();
        });
    });
</script>
