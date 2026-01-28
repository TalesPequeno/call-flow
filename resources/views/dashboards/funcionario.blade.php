<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Card de boas-vindas --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-sm text-gray-500">Bem-vindo(a),</p>
                    <p class="text-2xl font-semibold">{{ auth()->user()->name }}</p>

                    <p class="mt-3 text-gray-600">
                        Aqui você acompanha somente os seus chamados e o andamento dos atendimentos.
                    </p>
                </div>
            </div>

            {{-- Estatísticas (placeholders por enquanto) --}}
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['Meus chamados', '0'],
                    ['Abertos', '0'],
                    ['Em atendimento', '0'],
                    ['Resolvidos', '0'],
                ] as $stat)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <p class="text-sm text-gray-500">{{ $stat[0] }}</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stat[1] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Lista rápida (placeholder por enquanto) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">Últimos chamados</h3>

                        {{-- Quando você criar a tela de "abrir chamado", aponta pra rota correta --}}
                        <a href="#"
                           class="inline-flex items-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:opacity-90">
                            Abrir chamado
                        </a>
                    </div>

                    <div class="mt-4">
                        <div class="rounded-lg border bg-gray-50 p-4 text-sm text-gray-600">
                            Ainda não há chamados para exibir (ou você ainda não criou as tabelas).
                        </div>

                        {{-- Depois, você troca esse bloco por um foreach $tickets --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
