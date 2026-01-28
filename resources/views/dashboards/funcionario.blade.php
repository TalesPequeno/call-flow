<x-app-layout>
    <div class="py-12" x-data="{
        openModal: {{ $errors->any() ? 'true' : 'false' }},
        detailOpen: false,
        selected: null,
        openDetail(ticket) {
            this.selected = ticket;
            this.detailOpen = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Sucesso --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Erros --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <p class="font-semibold">Ops! Corrija os campos abaixo:</p>
                    <ul class="mt-2 list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Card de boas-vindas --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-sm text-gray-500">Bem-vindo(a),</p>
                    <p class="text-2xl font-semibold">{{ $user->name }}</p>

                    <p class="mt-3 text-gray-600">
                        Aqui você acompanha somente os seus chamados e o andamento dos atendimentos.
                    </p>
                </div>
            </div>

            {{-- Estatísticas --}}
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-6">
                @foreach ([
                    ['Meus chamados', $stats['meus_chamados'] ?? 0],
                    ['Abertos', $stats['abertos'] ?? 0],
                    ['Em atendimento', $stats['em_atendimento'] ?? 0],
                    ['Aguardando', $stats['aguardando'] ?? 0],
                    ['Resolvidos', $stats['resolvidos'] ?? 0],
                    ['Fechados', $stats['fechados'] ?? 0],
                ] as $stat)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <p class="text-sm text-gray-500">{{ $stat[0] }}</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stat[1] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Últimos chamados --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">Últimos chamados</h3>

                        <button @click="openModal = true"
                                class="inline-flex items-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:opacity-90">
                            Abrir chamado
                        </button>
                    </div>

                    <div class="mt-4 overflow-x-auto rounded-lg border">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium">Título</th>
                                    <th class="px-3 py-2 text-left font-medium">Status</th>
                                    <th class="px-3 py-2 text-left font-medium">Prioridade</th>
                                    <th class="px-3 py-2 text-left font-medium">Setor</th>
                                    <th class="px-3 py-2 text-left font-medium">Criado em</th>
                                    <th class="px-3 py-2 text-right font-medium">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($tickets as $ticket)
                                    <tr class="group hover:bg-gray-50">
                                        <td class="px-3 py-2">
                                            <div class="font-semibold text-gray-900">
                                                {{ $ticket->title }}
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 text-gray-700">
                                            {{ str_replace('_', ' ', $ticket->status) }}
                                        </td>
                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $ticket->priority }}
                                        </td>
                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $ticket->sector ?? '-' }}
                                        </td>
                                        <td class="px-3 py-2 text-gray-500 whitespace-nowrap">
                                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-3 py-2 text-right">
                                            <button
                                                type="button"
                                                @click="openDetail({
                                                    id: {{ $ticket->id }},
                                                    title: @js($ticket->title),
                                                    description: @js($ticket->description),
                                                    status: @js(str_replace('_', ' ', $ticket->status)),
                                                    priority: @js($ticket->priority),
                                                    sector: @js($ticket->sector),
                                                    created_at: @js($ticket->created_at->format('d/m/Y H:i'))
                                                })"
                                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-500 opacity-0 transition-opacity group-hover:opacity-100 hover:text-gray-900"
                                                title="Ver detalhes">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5C21.27 7.61 17 4.5 12 4.5Zm0 12a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Z"/>
                                                    <path d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-3 py-4 text-center text-gray-600">
                                            Ainda não há chamados para exibir.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- MODAL DETALHE CHAMADO --}}
        <div x-show="detailOpen"
             x-transition.opacity
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/25"
             style="display: none;">

            <div @click.away="detailOpen = false"
                 class="bg-white w-[640px] max-w-[90vw] rounded-2xl shadow-lg mx-4 p-6">

                <div class="pb-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold">Detalhe do chamado</h2>
                        <button @click="detailOpen = false" class="text-gray-400 hover:text-gray-600">×</button>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500">Título</p>
                        <p class="text-base font-semibold text-gray-900" x-text="selected?.title ?? '-'"></p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Descrição</p>
                        <p class="text-sm text-gray-700 whitespace-pre-line" x-text="selected?.description ?? '-'"></p>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-gray-500">Status</p>
                            <p class="text-gray-900" x-text="selected?.status ?? '-'"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Prioridade</p>
                            <p class="text-gray-900" x-text="selected?.priority ?? '-'"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Setor</p>
                            <p class="text-gray-900" x-text="selected?.sector ?? '-'"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Criado em</p>
                            <p class="text-gray-900" x-text="selected?.created_at ?? '-'"></p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-5">
                    <a
                        :href="selected ? `/tickets/${selected.id}` : '#'"
                        class="px-4 py-2 rounded-lg bg-gray-900 text-sm text-white hover:opacity-90"
                    >
                        Ver chamado
                    </a>
                    <button type="button"
                            @click="detailOpen = false"
                            class="px-4 py-2 rounded-lg bg-gray-100 text-sm text-gray-700 hover:bg-gray-200">
                        Fechar
                    </button>
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

                <form method="POST" action="{{ route('tickets.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Título *</label>
                        <input type="text" name="title" required value="{{ old('title') }}"
                               class="mt-2 w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Descrição *</label>
                        <textarea name="description" rows="4" required
                                  class="mt-2 w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Prioridade</label>
                            <select name="priority"
                                    class="mt-2 w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900">
                                <option value="baixa" {{ old('priority', 'baixa') === 'baixa' ? 'selected' : '' }}>Baixa</option>
                                <option value="media" {{ old('priority') === 'media' ? 'selected' : '' }}>Média</option>
                                <option value="alta" {{ old('priority') === 'alta' ? 'selected' : '' }}>Alta</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600">Setor</label>
                            <input type="text" name="sector" value="{{ old('sector') }}"
                                   class="mt-2 w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900"
                                   placeholder="TI, RH, Financeiro...">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button"
                                @click="openModal = false"
                                class="px-4 py-2 rounded-lg bg-red-500 text-sm text-white hover:bg-red-700">
                            Cancelar
                        </button>

                        <button type="submit"
                                class="px-4 py-2 rounded-lg bg-green-600 text-white text-sm hover:bg-green-700">
                            Criar Chamado
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
