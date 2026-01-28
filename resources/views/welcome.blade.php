<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ config('app.name', 'Call Flow') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-gray-100 text-gray-900 selection:bg-gray-900 selection:text-white">

<header class="border-b bg-white/70 backdrop-blur sticky top-0 z-50">
    <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="h-11 w-11 rounded-2xl bg-gray-900 text-white flex items-center justify-center font-semibold shadow-lg shadow-gray-900/30">
                CF
            </div>
            <div>
                <p class="text-xs text-gray-500 leading-none">Help Desk</p>
                <h1 class="text-lg font-semibold leading-none">{{ config('app.name', 'Call Flow') }}</h1>
            </div>
        </div>

        @if (Route::has('login'))
            <nav class="flex items-center gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:scale-105 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-lg border px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                        Entrar
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:scale-105 transition">
                            Criar conta
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </div>
</header>

<main class="mx-auto max-w-6xl px-4 py-16">
    <div class="grid gap-12 lg:grid-cols-2 lg:items-center">

        {{-- HERO TEXT --}}
        <div class="animate-fade-in">
            <p class="inline-flex items-center gap-2 rounded-full bg-gray-900/5 px-4 py-1 text-xs font-semibold text-gray-700">
                Laravel • Blade • Sistema Corporativo
            </p>

            <h2 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl leading-tight">
                Organize o suporte interno com <span class="text-gray-600">eficiência</span>
            </h2>

            <p class="mt-5 text-lg text-gray-600">
                Um sistema completo de Help Desk com controle de usuários, histórico de atendimentos e gestão de solicitações corporativas.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-gray-900/20 hover:scale-105 transition">
                        Ir para o sistema
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-gray-900/20 hover:scale-105 transition">
                        Entrar
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="rounded-xl border px-6 py-3 text-sm font-semibold hover:bg-gray-50 transition">
                            Criar conta
                        </a>
                    @endif
                @endauth

                <a href="#features"
                   class="rounded-xl border px-6 py-3 text-sm font-semibold hover:bg-gray-50 transition">
                    Ver funcionalidades
                </a>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-3">
                @foreach ([
                    ['Funcionário','Abre e acompanha solicitações'],
                    ['Técnico','Atende e atualiza status'],
                    ['Admin','Gerencia o sistema']
                ] as $card)
                    <div class="rounded-2xl border bg-white p-4 shadow-sm hover:shadow-lg transition">
                        <p class="text-sm font-semibold">{{ $card[0] }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ $card[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- HERO CARD --}}
        <div class="relative">
            <div class="absolute -inset-4 bg-gradient-to-r from-gray-900/10 to-gray-400/10 rounded-3xl blur-2xl"></div>

            <div class="relative rounded-3xl border bg-white/80 backdrop-blur p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold">Painel de Chamados</p>
                    <span class="rounded-full bg-white px-3 py-1 text-xs font-medium text-gray-600 border">
                        Demo UI
                    </span>
                </div>

                <div class="mt-6 space-y-4">
                    <div class="rounded-xl bg-gray-50 p-4 hover:bg-gray-100 transition">
                        <p class="text-sm font-medium">Chamados Abertos</p>
                        <p class="text-2xl font-bold text-gray-800">—</p>
                        <p class="mt-1 text-xs text-gray-500">Exibição real no Dashboard</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-xl bg-gray-50 p-4 hover:bg-gray-100 transition">
                            <p class="text-sm font-medium">Prioridades</p>
                            <p class="text-xs text-gray-600">Baixa • Média • Alta</p>
                        </div>

                        <div class="rounded-xl bg-gray-50 p-4 hover:bg-gray-100 transition">
                            <p class="text-sm font-medium">Notificações</p>
                            <p class="text-xs text-gray-600">E-mail automático</p>
                        </div>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4 hover:bg-gray-100 transition">
                        <p class="text-sm font-medium">Histórico</p>
                        <p class="text-xs text-gray-600">Registro completo de ações</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FEATURES --}}
    <section id="features" class="mt-20">
        <div class="flex flex-col gap-2">
            <h3 class="text-2xl sm:text-3xl font-bold tracking-tight">Funcionalidades principais</h3>
            <p class="text-gray-600">
                O essencial para um help desk interno bem organizado — com foco em produtividade e rastreabilidade.
            </p>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['Autenticação', 'Login, registro, recuperação de senha e sessão via Laravel Breeze.'],
                ['Controle de acesso (RBAC)', 'Permissões por perfil: funcionário, técnico e administrador.'],
                ['Paginação e filtros', 'Listagens rápidas e organizadas com filtros por prioridade e status.'],
                ['Anexos', 'Upload de arquivos para facilitar diagnóstico e evidências do atendimento.'],
                ['Notificações', 'Alertas por e-mail em mudanças de status e movimentações importantes.'],
                ['Logs e histórico', 'Rastreabilidade de ações, mensagens e alterações no atendimento.'],
            ] as $feature)
                <div class="rounded-2xl border bg-white p-5 shadow-sm hover:shadow-lg transition">
                    <div class="flex items-start gap-3">
                        <div class="mt-1 h-9 w-9 rounded-xl bg-gray-900 text-white flex items-center justify-center text-sm font-semibold shadow-md shadow-gray-900/20">
                            ✓
                        </div>
                        <div>
                            <p class="font-semibold">{{ $feature[0] }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $feature[1] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="mt-10 rounded-3xl border bg-white/70 backdrop-blur p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-gray-900">Pronto para começar?</p>
                    <p class="text-sm text-gray-600">Acesse agora e comece a organizar os atendimentos internos.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-gray-900/20 hover:scale-105 transition">
                            Abrir Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-gray-900/20 hover:scale-105 transition">
                            Entrar
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="rounded-xl border px-6 py-3 text-sm font-semibold hover:bg-gray-50 transition">
                                Criar conta
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="border-t bg-white/60 backdrop-blur">
    <div class="mx-auto max-w-6xl px-4 py-6 text-sm text-gray-500 flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-between">
        <p>© {{ date('Y') }} {{ config('app.name', 'Call Flow') }} • Help Desk Interno</p>
        <p class="text-xs">Feito com Laravel + Blade</p>
    </div>
</footer>

<style>
@keyframes fade-in {
    from { opacity:0; transform: translateY(10px); }
    to { opacity:1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in .7s ease-out both; }
</style>

</body>
</html>
