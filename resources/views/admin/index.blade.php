@extends('admin.layouts.admin')

@section('content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h1 class="text-2xl font-semibold sm:text-3xl">FAQ</h1>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <a href="{{ route('admin.faq.categories') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-border bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
                        <i class="fa-solid fa-folder mr-2"></i>
                        <span>Catégories</span>
                    </a>
                    <a href="{{ route('admin.faq.create') }}"
                       class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90">
                        <i class="fa-solid fa-plus mr-2"></i>
                        <span>Créer une FAQ</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('status'))
            <div class="mb-6 rounded-lg border-l-4 border-green-500 bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/20 dark:text-green-400">
                <div class="flex items-start">
                    <i class="fa-solid fa-circle-check mr-3 mt-0.5"></i>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <!-- Mobile Card View (visible only on mobile/tablet) -->
        <div class="space-y-4 lg:hidden">
            @forelse($items as $item)
                <div class="overflow-hidden rounded-lg border border-border bg-card shadow-sm">
                    <div class="p-4">
                        <!-- Question -->
                        <div class="mb-3">
                            <h3 class="font-medium leading-snug">{{ $item->question }}</h3>
                        </div>

                        <!-- Meta Information -->
                        <div class="mb-3 space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">Catégorie</span>
                                <span class="font-medium">{{ optional($item->category)->name ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">Position</span>
                                <span class="font-medium">{{ $item->position }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">Statut</span>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $item->published ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400' }}">
                                    <i class="fa-solid {{ $item->published ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1.5 text-[10px]"></i>
                                    {{ $item->published ? 'Publié' : 'Brouillon' }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 border-t border-border pt-3">
                            <a href="{{ route('admin.faq.edit', $item) }}"
                               class="flex-1 inline-flex items-center justify-center rounded-md bg-primary/10 px-3 py-2 text-sm font-medium text-primary hover:bg-primary/20">
                                <i class="fa-solid fa-pen mr-2"></i>
                                Modifier
                            </a>
                            <form action="{{ route('admin.faq.destroy', $item) }}" method="POST" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center rounded-md bg-destructive/10 px-3 py-2 text-sm font-medium text-destructive hover:bg-destructive/20"
                                        onclick="return confirm('Supprimer cette FAQ ?')">
                                    <i class="fa-solid fa-trash mr-2"></i>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-border bg-card p-12 text-center shadow-sm">
                    <i class="fa-solid fa-inbox mb-3 text-4xl text-muted-foreground/50"></i>
                    <p class="text-sm text-muted-foreground">Aucun élément pour le moment.</p>
                    <a href="{{ route('admin.faq.create') }}"
                       class="mt-4 inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Créer votre première FAQ
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden lg:block overflow-hidden rounded-xl border border-border bg-card shadow-sm">
            <table class="w-full">
                <thead class="bg-muted/50">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-muted-foreground">Question</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-muted-foreground">Catégorie</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-muted-foreground">Position</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-muted-foreground">Publié</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-muted-foreground">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-card divide-y divide-border">
                @forelse($items as $item)
                    <tr class="transition-colors hover:bg-muted/30">
                        <td class="px-6 py-4 text-sm font-medium text-center align-middle">{{ $item->question }}</td>
                        <td class="px-6 py-4 text-sm text-muted-foreground text-center align-middle">{{ optional($item->category)->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-muted-foreground text-center align-middle">{{ $item->position }}</td>
                        <td class="px-6 py-4 text-center align-middle">
                                <span class="inline-flex items-center justify-center">
                                    <i class="fa-solid {{ $item->published ? 'fa-circle-check text-green-600 dark:text-green-400' : 'fa-circle-xmark text-gray-500 dark:text-gray-400' }} text-base"></i>
                                </span>
                        </td>
                        <td class="px-6 py-4 text-center align-middle">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.faq.edit', $item) }}"
                                   class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.faq.destroy', $item) }}" method="POST" onsubmit="return confirm('Supprimer cette FAQ ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-destructive/10 h-9 px-3 text-destructive">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-inbox mb-3 text-4xl text-muted-foreground/50"></i>
                                <p class="text-sm text-muted-foreground">Aucun élément pour le moment.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($items->hasPages())
            <div class="mt-6">
                {{ $items->links() }}
            </div>
        @endif
    </div>
@endsection
