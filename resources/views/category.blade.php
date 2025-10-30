@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <section class="relative -mx-4 md:mx-0 mb-10 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-slate-900 dark:to-slate-800 opacity-60"></div>
        <div class="relative container mx-auto px-4 py-10">
            <div class="max-w-3xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-foreground leading-tight">{{ $category->name }}</h1>
                    <p class="mt-2 text-muted-foreground text-sm">Questions fréquentes de la catégorie.</p>
                </div>
                <a href="{{ route('faq.index') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-md text-sm border border-input bg-background hover:bg-accent hover:text-accent-foreground px-3 py-1.5">
                    <i class="fas fa-arrow-left text-xs"></i> Toutes les FAQ
                </a>
            </div>
        </div>
    </section>

    <div x-data="{ q: '' }" class="mx-auto max-w-3xl px-4">
        <div class="mb-8">
            <label class="sr-only" for="faq-cat-search">Rechercher dans la catégorie</label>
            <div class="relative">
                <input
                    id="faq-cat-search"
                    x-model="q"
                    type="search"
                    placeholder="Rechercher dans {{ $category->name }}…"
                    class="w-full rounded-lg border bg-white/80 dark:bg-slate-800/80 backdrop-blur px-4 py-2.5 pr-10 outline-none focus:ring-2 focus:ring-primary/50"
                >
                <i class="fas fa-search absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div class="space-y-2">
            @foreach($category->items as $faq)
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
            @endforeach
        </div>

        <template x-if="q !== '' && document.querySelectorAll('[x-cloak][style*=display\\: none]').length === document.querySelectorAll('[x-cloak]').length">
            <div class="mt-6 rounded-xl border bg-white/80 dark:bg-slate-800/80 backdrop-blur p-6 text-center">
                <p class="text-sm text-muted-foreground">Aucun résultat pour « <span class="font-medium" x-text="q"></span> » dans cette catégorie.</p>
            </div>
        </template>
    </div>
@endsection
