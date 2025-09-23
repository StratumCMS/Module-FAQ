@extends('admin.layouts.admin')
@section('title', 'Liste des FAQs')

@section('content')
    <div class="px-6 py-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">FAQ</h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.faq.categories') }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border hover:bg-accent hover:text-accent-foreground h-9 px-3 hover-glow-purple">Catégories</a>
                <a href="{{ route('admin.faq.create') }}" class="inline-flex items-center gap-2 rounded-md bg-primary text-primary-foreground text-sm font-medium px-4 py-2 hover:bg-primary/90">Créer</a>
            </div>
        </div>

        @if(session('status'))
            <div class="mb-4 rounded-md border-l-4 border-green-500 bg-green-50 p-4 text-sm">{{ session('status') }}</div>
        @endif

        <div class="overflow-hidden rounded-xl border">
            <table class="min-w-full divide-y">
                <thead class="bg-card">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">Question</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">Catégorie</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">Position</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">Publié</th>
                    <th class="px-4 py-2"></th>
                </tr>
                </thead>
                <tbody class="divide-y">
                @forelse($items as $item)
                    <tr>
                        <td class="px-4 px-2">{{ $item->question }}</td>
                        <td class="px-4 px-2">{{ optional($item->category)->name ?? 'N/A' }}</td>
                        <td class="px-4 px-2">{{ $item->position }}</td>
                        <td class="px-4 px-2">
                            <span class="rounded-full px-2 py-0.5 text-xs {{ $item->published ? 'bg-green-100 text-muted' : 'bg-gray-100 text-gray-600' }}">
                                {{ $item->published ? 'Oui' : 'Non' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <a class="text-sm underline mr-2" href="{{ route('admin.faq.edit', $item) }}">Modifier</a>
                            <form action="{{ route('admin.faq.destroy', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-sm text-red-600 underline" onclick="return confirm('Supprimer cette faq ?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">Aucun élément trouvée.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $items->links() }}
        </div>

    </div>
@endsection
