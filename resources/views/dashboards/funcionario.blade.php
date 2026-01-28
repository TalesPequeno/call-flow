<x-app-layout>
    <div class="py-12" x-data="{ openModal: false }">
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

            {{-- Estatísticas --}}
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

            {{-- Lista rápida --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">Últimos chamados</h3>

                        <button @click="openModal = true"
                            class="inline-flex items-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:opacity-90">
                            Abrir chamado
                        </button>
                    </div>

                    <div class="mt-4">
                        <div class="rounded-lg border bg-gray-50 p-4 text-sm text-gray-600">
                            Ainda não há chamados para exibir.
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- MODAL NOVO CHAMADO --}}
        <div x-show="openModal"
             x-transition.opacity
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/25"
             style="display: none;">

            <div @click.away="openModal = false"
                 class="bg-white w-[640px] max-w-[90vw] rounded-2xl shadow-lg mx-4 p-6">

                <div class="pb-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold">Novo chamado</h2>
                        <button @click="openModal = false" class="text-gray-400 hover:text-gray-600">×</button>
                    </div>
                </div>

                <form method="POST" action="#" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Título *</label>
                        <input type="text" name="title" required
                               class="mt-2 w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Descrição *</label>
                        <textarea name="description" rows="4" required
                                  class="mt-2 w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900"></textarea>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Prioridade</label>
                            <select name="priority"
                                    class="mt-2 w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900">
                                <option value="baixa" selected>Baixa</option>
                                <option value="media">Média</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600">Setor</label>
                            <input type="text" name="sector"
                                   class="mt-2 w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900"
                                   placeholder="TI, RH, Financeiro...">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button"
                                @click="openModal = false"
                                class="px-4 py-2 rounded-lg bg-green-600 text-sm text-white hover:bg-green-700">
                            Cancelar
                        </button>

                        <button type="submit"
                                class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:opacity-90">
                            Criar Chamado
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
