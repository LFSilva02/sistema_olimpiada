<div id="sidebar" class="sidebar z-10 bg-blue-300 text-white fixed top-0 left-0 h-screen w-64 transition-transform sidebar-hidden">
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
        <a href="#" class="text-black">Premiados</a>
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
