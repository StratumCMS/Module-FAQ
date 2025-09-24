@extends('admin.layouts.admin')
@section('title', 'Catégories FAQ')

@section('content')
    <div class="px-4 sm:px-6 py-6 sm:py-8 space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h1 class="text-xl sm:text-2xl font-semibold">Catégories FAQ</h1>
            <a href="{{ route('admin.faq.index') }}" class="text-sm underline">← Retour aux FAQ</a>
        </div>

        @if(session('status'))
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-3 text-sm border-l-4 border-l-success glow-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- LISTE — mobile en cartes --}}
            <div class="space-y-3 lg:space-y-0">
                <div class="lg:hidden space-y-3">
                    @forelse($categories as $cat)
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm text-muted-foreground">Nom</p>
                                    <h3 class="font-medium text-base truncate">{{ $cat->name }}</h3>
                                    <p class="text-xs text-muted-foreground mt-1">Slug : <span class="font-mono">{{ $cat->slug }}</span></p>
                                </div>
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                {{ $cat->is_public ? 'bg-green-50 text-green-600 border-green-200' : 'bg-gray-100 text-gray-700 border-gray-200' }}">
                {{ $cat->is_public ? 'Publique' : 'Privée' }}
              </span>
                            </div>

                            <div class="mt-3 flex items-center justify-between text-sm">
                                <span>Position : <strong>{{ $cat->position }}</strong></span>

                                <details class="text-right">
                                    <summary class="cursor-pointer text-sm underline">Modifier</summary>
                                    <div class="mt-3">
                                        <form action="{{ route('admin.faq.categories.update',$cat) }}" method="POST" class="space-y-3 p-4 rounded-lg border bg-card">
                                            @csrf @method('PUT')
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-medium">Nom</label>
                                                <input name="name" class="w-full rounded-lg border px-3 py-2 bg-background" value="{{ $cat->name }}" required maxlength="100">
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-medium">Slug</label>
                                                <input name="slug" class="w-full rounded-lg border px-3 py-2 bg-background" value="{{ $cat->slug }}" required maxlength="100">
                                            </div>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="space-y-1.5">
                                                    <label class="text-xs font-medium">Position</label>
                                                    <input type="number" min="0" name="position" class="w-full rounded-lg border px-3 py-2 bg-background" value="{{ $cat->position }}">
                                                </div>
                                                <div class="flex items-end">
                                                    <label class="inline-flex items-center gap-2">
                                                        <input type="checkbox" name="is_public" value="1" @checked($cat->is_public) class="rounded border">
                                                        <span>Publique</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button class="rounded-lg bg-primary text-primary-foreground px-3 py-1.5 text-sm hover:bg-primary/90">Mettre à jour</button>
                                                <form action="{{ route('admin.faq.categories.destroy',$cat) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button class="text-sm text-destructive hover:bg-destructive/10 rounded-md px-3 py-1.5">Supprimer</button>
                                                </form>
                                            </div>
                                        </form>
                                    </div>
                                </details>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-8 text-center text-muted-foreground">
                            Aucune catégorie pour le moment.
                        </div>
                    @endforelse
                </div>

                {{-- LISTE — desktop tableau --}}
                <div class="hidden lg:block rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="border-b bg-muted/10 px-4 py-3 font-medium">Catégories existantes</div>
                    <div class="overflow-auto">
                        <table class="w-full table-auto text-sm">
                            <thead>
                            <tr class="bg-muted/10 text-muted-foreground">
                                <th class="px-4 py-2 text-left">Nom</th>
                                <th class="px-4 py-2 text-left">Slug</th>
                                <th class="px-4 py-2 text-left">Position</th>
                                <th class="px-4 py-2 text-left">Publique</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $cat)
                                <tr class="hover:bg-muted/20">
                                    <td class="px-4 py-2">{{ $cat->name }}</td>
                                    <td class="px-4 py-2 font-mono text-muted-foreground">{{ $cat->slug }}</td>
                                    <td class="px-4 py-2">{{ $cat->position }}</td>
                                    <td class="px-4 py-2">
                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                      {{ $cat->is_public ? 'bg-green-50 text-green-600 border-green-200' : 'bg-gray-100 text-gray-700 border-gray-200' }}">
                      {{ $cat->is_public ? 'Oui' : 'Non' }}
                    </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <details class="inline-block">
                                            <summary class="text-sm underline cursor-pointer">Modifier</summary>
                                            <div class="mt-3">
                                                <form action="{{ route('admin.faq.categories.update',$cat) }}" method="POST" class="space-y-3 p-4 rounded-lg border bg-card">
                                                    @csrf @method('PUT')
                                                    <div>
                                                        <label class="mb-1 block text-xs font-medium">Nom</label>
                                                        <input name="name" class="w-full rounded-lg border px-3 py-2 bg-background" value="{{ $cat->name }}" required maxlength="100">
                                                    </div>
                                                    <div>
                                                        <label class="mb-1 block text-xs font-medium">Slug</label>
                                                        <input name="slug" class="w-full rounded-lg border px-3 py-2 bg-background" value="{{ $cat->slug }}" required maxlength="100">
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="mb-1 block text-xs font-medium">Position</label>
                                                            <input type="number" min="0" name="position" class="w-full rounded-lg border px-3 py-2 bg-background" value="{{ $cat->position }}">
                                                        </div>
                                                        <div class="flex items-end">
                                                            <label class="inline-flex items-center gap-2">
                                                                <input type="checkbox" name="is_public" value="1" @checked($cat->is_public) class="rounded border">
                                                                <span>Publique</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <button class="rounded-lg bg-primary text-primary-foreground px-3 py-1.5 text-sm hover:bg-primary/90">Mettre à jour</button>
                                                        <form action="{{ route('admin.faq.categories.destroy',$cat) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')" class="inline">
                                                            @csrf @method('DELETE')
                                                            <button class="text-sm text-destructive hover:bg-destructive/10 rounded-md px-3 py-1.5">Supprimer</button>
                                                        </form>
                                                    </div>
                                                </form>
                                            </div>
                                        </details>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-muted-foreground">Aucune catégorie pour le moment.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- CRÉATION --}}
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                <div class="border-b bg-muted/10 px-4 py-3 font-medium">Créer une catégorie</div>
                <div class="p-4">
                    <form action="{{ route('admin.faq.categories.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium">Nom</label>
                            <input type="text" name="name" class="w-full h-10 px-3 rounded-md border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring" value="{{ old('name') }}" required maxlength="100">
                            @error('name') <p class="text-destructive text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium">Slug</label>
                            <input type="text" name="slug" class="w-full h-10 px-3 rounded-md border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring" value="{{ old('slug') }}" required maxlength="100">
                            @error('slug') <p class="text-destructive text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-sm font-medium">Position</label>
                                <input type="number" min="0" name="position" class="w-full h-10 px-3 rounded-md border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring" value="{{ old('position', 0) }}">
                                @error('position') <p class="text-destructive text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex items-end">
                                <label class="inline-flex items-center gap-2">
                                    <input type="checkbox" name="is_public" value="1" @checked(old('is_public', true)) class="h-4 w-4 text-primary bg-background border-border rounded focus:ring-primary focus:ring-2 focus:ring-offset-0 transition">
                                    <span>Publique</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-primary-foreground text-sm font-medium bg-primary hover:bg-primary/90 hover-glow-purple h-10 px-4">
                                Créer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
