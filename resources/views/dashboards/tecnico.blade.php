<x-app-layout>
    <div class="py-12" x-data="{
        detailOpen: false,
        selected: null,
        openDetail(ticket) {
            this.selected = ticket;
            this.detailOpen = true;
        },
        get primaryActionLabel() {
            if (!this.selected) return 'Responder chamado';
            if (this.selected.status_raw === 'aberto' && !this.selected.assigned_to) {
                return 'Assumir chamado';
            }
            return 'Responder chamado';
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Card de boas-vindas --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-sm text-gray-500">Bem-vindo(a),</p>
                    <p class="text-2xl font-semibold">{{ $user->name }}</p>

                    <p class="mt-3 text-gray-600">
                        Aqui você acompanha os chamados abertos e os que estão sob seu atendimento.
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

            {{-- Meus atendimentos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">Meus atendimentos</h3>
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
                                @forelse ($myTickets as $ticket)
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
                                                    status_raw: @js($ticket->status),
                                                    priority: @js($ticket->priority),
                                                    sector: @js($ticket->sector),
                                                    assigned_to: @js($ticket->assigned_to),
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
                                            Você ainda não tem chamados em atendimento.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Chamados abertos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">Chamados abertos</h3>
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
                                @forelse ($openTickets as $ticket)
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
                                                    status_raw: @js($ticket->status),
                                                    priority: @js($ticket->priority),
                                                    sector: @js($ticket->sector),
                                                    assigned_to: @js($ticket->assigned_to),
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
                                            Não há chamados abertos no momento.
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
                        :href="selected ? `/tickets/${selected.id}/responder` : '#'"
                        class="px-4 py-2 rounded-lg bg-gray-900 text-sm text-white hover:opacity-90"
                    >
                        <span x-text="primaryActionLabel"></span>
                    </a>
                    <button type="button"
                            @click="detailOpen = false"
                            class="px-4 py-2 rounded-lg bg-gray-100 text-sm text-gray-700 hover:bg-gray-200">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
