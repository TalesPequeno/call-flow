<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs text-gray-500">Chamado</p>
                            <h2 class="text-xl font-semibold">{{ $ticket->title }}</h2>
                        </div>
                        <div class="text-xs text-gray-500 whitespace-nowrap">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="mt-4 grid sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-gray-500">Solicitante</p>
                            <p class="text-gray-900">{{ $ticket->owner?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Técnico responsável</p>
                            <p class="text-gray-900">{{ $ticket->technician?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Status</p>
                            <p class="text-gray-900">{{ str_replace('_', ' ', $ticket->status) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Prioridade</p>
                            <p class="text-gray-900">{{ $ticket->priority }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Setor</p>
                            <p class="text-gray-900">{{ $ticket->sector ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs text-gray-500">Descrição</p>
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $ticket->description }}</p>
                    </div>
                </div>
            </div>

            @php
                $authId = auth()->id();
                $user = auth()->user();
                $canRespond = $user && (
                    $ticket->user_id === $user->id ||
                    $ticket->assigned_to === $user->id ||
                    $user->role === 'admin'
                );
            @endphp

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold">Conversa</h3>

                    <div
                        class="mt-4 space-y-3 max-h-96 overflow-y-auto pr-2"
                        x-data
                        x-init="$el.scrollTop = $el.scrollHeight"
                    >
                        @forelse ($ticket->messages->reverse() as $message)
                            @php
                                $isMine = $authId && $message->user_id === $authId;
                            @endphp
                            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[80%] rounded-2xl px-4 py-3 shadow-sm {{ $isMine ? 'bg-green-50 text-gray-900' : 'bg-gray-100 text-gray-900' }}">
                                    <div class="flex items-center justify-between gap-3 text-[11px] text-gray-500">
                                        <span>{{ $message->user?->name ?? 'Usuário' }}</span>
                                        <span>{{ $message->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="mt-2 text-sm whitespace-pre-line">{{ $message->message }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-lg border bg-gray-50 p-4 text-sm text-gray-600">
                                Ainda não há mensagens neste chamado.
                            </div>
                        @endforelse
                    </div>

                    @if ($canRespond)
                        <div class="mt-6 border-t pt-4">
                            <form method="POST" action="{{ route('tickets.messages.store', $ticket) }}" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Mensagem *</label>
                                    <textarea name="message" rows="3" required
                                              class="mt-2 w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900">{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center justify-end gap-3">
                                    <button type="submit"
                                            class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:opacity-90">
                                        Enviar
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 rounded-lg bg-gray-900 text-sm text-white hover:opacity-90">
                    Voltar ao dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
