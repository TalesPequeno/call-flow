<x-app-layout>
    <div class="py-12" x-data="{ openModal: {{ $errors->any() ? 'true' : 'false' }} }">
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

            {{-- Estatísticas (placeholder por enquanto) --}}
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

                    <div class="mt-4 space-y-3">
                        @forelse ($tickets as $ticket)
                            <div class="border rounded-lg p-4 flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">
                                        {{ $ticket->title }}
                                    </p>

                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                                        {{ $ticket->description }}
                                    </p>

                                    <div class="mt-3 flex flex-wrap gap-2 text-xs">
                                        <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                            Status: {{ str_replace('_', ' ', $ticket->status) }}
                                        </span>

                                        <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                            Prioridade: {{ $ticket->priority }}
                                        </span>

                                        @if ($ticket->sector)
                                            <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                                Setor: {{ $ticket->sector }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-xs text-gray-500 whitespace-nowrap">
                                    {{ $ticket->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        @empty
                            <div class="rounded-lg border bg-gray-50 p-4 text-sm text-gray-600">
                                Ainda não há chamados para exibir.
                            </div>
                        @endforelse
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
