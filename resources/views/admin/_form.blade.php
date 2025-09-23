@php

    $action = $action ?? route('admin.faq.store');
    $method = $method ?? 'POST';

@endphp

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div>
        <label class="mb-1 block text-sm font-medium">Question</label>
        <input type="text" name="question" value="{{ old('question', $item->question ?? '') }}" class="form-input w-full px-3 py-2" required maxlength="255">
        @error('question') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium">Réponse</label>
        <textarea rows="6" name="answer" class="form-input w-full px-3 py-2" required>{{ old('answer', $item->answer ?? '') }}</textarea>
        @error('answer') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="mb-1 block text-sm font-medium">Catégorie</label>
            <select name="faq_category_id" class="w-full form-select px-3 py-2">
                <option value="">- Aucune</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('faq_category_id', $item->faq_category_id ?? null) == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('faq_category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Position</label>
            <input type="number" class="form-input" name="position" min="0" value="{{ old('position', $item->position ?? 0) }}">
            @error('position') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex-items-end">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="published" value="1" @checked(old('published', $item->published ?? true)) class="rounded border">
                <span>Publié</span>
            </label>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <button class="rounded-lg bg-card text-white px-4 py-2 text-sm hover-glow-purple">Enregistrer</button>
        <a href="{{ route('admin.faq.index') }}" class="text-sm underline">Annuler</a>
    </div>

</form>
