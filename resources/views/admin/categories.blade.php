@extends('admin.layouts.admin')

@section('title', 'Crée une catégorie')

@section('content')
    <div class="px-6 py-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Catégories FAQ</h1>
            <a href="{{ route('admin.faq.index') }}" class="text-sm underline">← Retour aux FAQ</a>
        </div>

        @if(session('status'))
            <div class="mb-4 rounded-md border-l-4 border-green-500 bg-green-50 p-4 text-sm">{{ session('status') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Liste -->
            <div class="rounded-xl border">
                <div class="border-b bg-gray-50 px-4 py-3 font-medium">Catégories existantes</div>
                <div class="p-4">
                    <div class="overflow-hidden rounded-lg border">
                        <table class="min-w-full divide-y">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">Nom</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">Slug</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">Position</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">Publique</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                            </thead>
                            <tbody class="divide-y">
                            @forelse($categories as $cat)
                                <tr>
                                    <td class="px-4 py-2">{{ $cat->name }}</td>
                                    <td class="px-4 py-2">{{ $cat->slug }}</td>
                                    <td class="px-4 py-2">{{ $cat->position }}</td>
                                    <td class="px-4 py-2">
                  <span class="rounded-full px-2 py-0.5 text-xs {{ $cat->is_public ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ $cat->is_public ? 'Oui' : 'Non' }}
                  </span>
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <!-- Formulaire inline d’édition -->
                                        <details class="inline-block">
                                            <summary class="text-sm underline cursor-pointer">Modifier</summary>
                                            <div class="mt-3">
                                                <form action="{{ route('admin.faq.categories.update',$cat) }}" method="POST" class="space-y-3 p-4 rounded-lg border">
                                                    @csrf @method('PUT')
                                                    <div>
                                                        <label class="mb-1 block text-xs font-medium">Nom</label>
                                                        <input name="name" class="w-full rounded-lg border px-3 py-2" value="{{ $cat->name }}" required maxlength="100">
                                                    </div>
                                                    <div>
                                                        <label class="mb-1 block text-xs font-medium">Slug</label>
                                                        <input name="slug" class="w-full rounded-lg border px-3 py-2" value="{{ $cat->slug }}" required maxlength="100">
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="mb-1 block text-xs font-medium">Position</label>
                                                            <input type="number" min="0" name="position" class="w-full rounded-lg border px-3 py-2" value="{{ $cat->position }}">
                                                        </div>
                                                        <div class="flex items-end">
                                                            <label class="inline-flex items-center gap-2">
                                                                <input type="checkbox" name="is_public" value="1" @checked($cat->is_public) class="rounded border">
                                                                <span>Publique</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <button class="rounded-lg bg-gray-900 text-white px-3 py-1.5 text-sm hover:bg-black">Mettre à jour</button>
                                                        <form action="{{ route('admin.faq.categories.destroy',$cat) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')" class="inline">
                                                            @csrf @method('DELETE')
                                                            <button class="text-sm text-red-600 underline">Supprimer</button>
                                                        </form>
                                                    </div>
                                                </form>
                                            </div>
                                        </details>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">Aucune catégorie pour le moment.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Création -->
            <div class="rounded-xl border">
                <div class="border-b bg-gray-50 px-4 py-3 font-medium">Créer une catégorie</div>
                <div class="p-4">
                    <form action="{{ route('admin.faq.categories.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="mb-1 block text-sm font-medium">Nom</label>
                            <input type="text" name="name" class="form-input w-full rounded-lg border px-3 py-2" value="{{ old('name') }}" required maxlength="100">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium">Slug</label>
                            <input type="text" name="slug" class="form-input w-full rounded-lg border px-3 py-2" value="{{ old('slug') }}" required maxlength="100">
                            @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium">Position</label>
                                <input type="number" min="0" name="position" class="form-input w-full rounded-lg border px-3 py-2" value="{{ old('position', 0) }}">
                                @error('position') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex items-end">
                                <label class="inline-flex items-center gap-2">
                                    <input type="checkbox" name="is_public" value="1" @checked(old('is_public', true)) class="rounded border">
                                    <span>Publique</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <button class="rounded-lg bg-gray-900 text-white px-4 py-2 text-sm hover:bg-black">Créer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
