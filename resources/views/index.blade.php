@extends('layouts.app')

@section('title', 'Foire aux questions')

@section('content')
    <section class="relative -mx-4 md:mx-0 mb-10 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-slate-900 dark:to-slate-800 opacity-60"></div>
        <div class="relative container mx-auto px-4 py-12">
            <div class="max-w-3xl mx-auto text-center">
                <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-secondary text-secondary-foreground backdrop-blur-sm border border-transparent mb-4">
                    ❓ Centre d’aide
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-foreground leading-tight">Foire aux questions</h1>
                <p class="mt-3 text-muted-foreground">Trouvez rapidement des réponses aux questions les plus courantes.</p>
            </div>
        </div>
    </section>

    <div x-data="{ q: '' }" class="mx-auto max-w-3xl px-4">
        <!-- Barre de recherche -->
        <div class="mb-8">
            <label class="sr-only" for="faq-search">Rechercher</label>
            <div class="relative">
                <input
                    id="faq-search"
                    x-model="q"
                    type="search"
                    placeholder="Rechercher une question…"
                    class="w-full rounded-lg border bg-white/80 dark:bg-slate-800/80 backdrop-blur px-4 py-2.5 pr-10 outline-none focus:ring-2 focus:ring-primary/50"
                >
                <i class="fas fa-search absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Astuce : tape “paiement”, “compte”, “sécurité”…</p>
        </div>

        {{-- Bloc "Général" (FAQ sans catégorie) --}}
        @if($items->count())
            <div class="mb-10">
                <h2 class="text-lg font-semibold mb-3 text-foreground">Général</h2>
                <div class="space-y-2">
                    @foreach($items as $faq)
                        <details
                            x-show="q === '' || '{{ Str::of($faq->question)->lower()->replace("'", "\\'") }}'.includes(q.toLowerCase())"
                            x-cloak
                            class="group rounded-xl border bg-white/80 dark:bg-slate-800/80 backdrop-blur p-4 transition hover:shadow"
                        >
                            <summary class="flex cursor-pointer list-none items-center justify-between">
                                <span class="text-base font-medium">{{ $faq->question }}</span>
                                <span class="ml-3 transition group-open:rotate-180">
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </span>
                            </summary>
                            <div class="pt-3 text-sm leading-relaxed prose max-w-none prose-p:my-2 dark:prose-invert">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Catégories --}}
        @foreach($categories as $cat)
            <section class="mb-10">
                <div class="mb-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <h2 class="text-lg font-semibold text-foreground">{{ $cat->name }}</h2>
                    <a href="{{ route('faq.category', $cat->slug) }}"
                       class="inline-flex items-center justify-center gap-2 rounded-md text-sm border border-input bg-background hover:bg-accent hover:text-accent-foreground px-3 py-1.5">
                        Voir la catégorie <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="space-y-2">
                    @forelse($cat->items as $faq)
                        <details
                            x-show="q === '' || '{{ Str::of($faq->question)->lower()->replace("'", "\\'") }}'.includes(q.toLowerCase())"
                            x-cloak
                            class="group rounded-xl border bg-white/80 dark:bg-slate-800/80 backdrop-blur p-4 transition hover:shadow"
                        >
                            <summary class="flex cursor-pointer list-none items-center justify-between">
                                <span class="text-base font-medium">{{ $faq->question }}</span>
                                <span class="ml-3 transition group-open:rotate-180">
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </span>
                            </summary>
                            <div class="pt-3 text-sm leading-relaxed prose max-w-none dark:prose-invert">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </details>
                    @empty
                        <p class="text-sm text-gray-500">Aucune question pour cette catégorie.</p>
                    @endforelse
                </div>
            </section>
        @endforeach

        <!-- Message "aucun résultat" côté client -->
        <template x-if="q !== '' && document.querySelectorAll('[x-cloak][style*=display\\: none]').length === document.querySelectorAll('[x-cloak]').length">
            <div class="rounded-xl border bg-white/80 dark:bg-slate-800/80 backdrop-blur p-6 text-center">
                <p class="text-sm text-muted-foreground">Aucun résultat pour « <span class="font-medium" x-text="q"></span> ».</p>
            </div>
        </template>
    </div>
@endsection
