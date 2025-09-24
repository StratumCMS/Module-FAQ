@extends('admin.layouts.admin')
@section('title', 'Liste des FAQs')

@section('content')
    <div class="px-4 sm:px-6 py-6 sm:py-8 space-y-4">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h1 class="text-xl sm:text-2xl font-semibold">FAQ</h1>
            <div class="flex flex-row items-center gap-2">
                <a href="{{ route('admin.faq.categories') }}"
                   class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3 hover-glow-purple">
                    <i class="fa-regular fa-folder"></i> Catégories
                </a>
                <a href="{{ route('admin.faq.create') }}"
                   class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-primary-foreground text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-primary hover:bg-primary/90 hover-glow-purple h-9 px-4">
                    <i class="fas fa-plus"></i> Créer
                </a>
            </div>
        </div>


    @if(session('status'))
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-3 text-sm border-l-4 border-l-success glow-success">
                {{ session('status') }}
            </div>
        @endif

        {{-- LISTE MOBILE — cartes empilées --}}
        <div class="md:hidden space-y-3">
            @forelse($items as $item)
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-4">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="font-medium text-base leading-5 flex-1">{{ $item->question }}</h3>
                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
            {{ $item->published ? 'bg-green-50 text-green-600 border-green-200' : 'bg-gray-100 text-gray-700 border-gray-200' }}">
            {{ $item->published ? 'Publié' : 'Brouillon' }}
          </span>
                    </div>

                    <div class="mt-3 grid grid-cols-2 gap-4 text-sm">
                        <div class="space-y-0.5">
                            <p class="text-muted-foreground">Catégorie</p>
                            <p class="font-medium">{{ optional($item->category)->name ?? 'N/A' }}</p>
                        </div>
                        <div class="space-y-0.5 text-right">
                            <p class="text-muted-foreground">Position</p>
                            <p class="font-medium">{{ $item->position }}</p>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-end gap-2">
                        <a href="{{ route('admin.faq.edit',$item) }}"
                           class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('admin.faq.destroy',$item) }}" method="POST" onsubmit="return confirm('Supprimer cette FAQ ?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium h-9 px-3 text-destructive hover:bg-destructive/10">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-8 text-center text-muted-foreground">
                    <i class="fas fa-question-circle fa-2x mb-3 opacity-60"></i>
                    <div>Aucun élément trouvé</div>
                </div>
            @endforelse
        </div>

        {{-- LISTE DESKTOP — tableau dense --}}
        <div class="hidden md:block rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="overflow-auto">
                <table class="w-full table-auto text-sm">
                    <thead>
                    <tr class="bg-muted/10 text-muted-foreground">
                        <th class="px-4 py-2 text-left">Question</th>
                        <th class="px-4 py-2 text-left">Catégorie</th>
                        <th class="px-4 py-2 text-left">Position</th>
                        <th class="px-4 py-2 text-left">Statut</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($items as $item)
                        <tr class="hover:bg-muted/20">
                            <td class="px-4 py-2 max-w-[40rem]">
                                <span class="line-clamp-2">{{ $item->question }}</span>
                            </td>
                            <td class="px-4 py-2">{{ optional($item->category)->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $item->position }}</td>
                            <td class="px-4 py-2">
              <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                {{ $item->published ? 'bg-green-50 text-green-600 border-green-200' : 'bg-gray-100 text-gray-700 border-gray-200' }}">
                {{ $item->published ? 'Publié' : 'Brouillon' }}
              </span>
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.faq.edit',$item) }}" class="btn btn-ghost btn-sm hover-glow-purple">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.faq.destroy',$item) }}" method="POST" onsubmit="return confirm('Supprimer cette FAQ ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-ghost btn-sm text-destructive hover:bg-destructive/10">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-muted-foreground">
                                <i class="fas fa-question-circle fa-2x mb-4 opacity-50"></i>
                                <div>Aucun élément trouvé</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>{{ $items->links() }}</div>
    </div>
@endsection
