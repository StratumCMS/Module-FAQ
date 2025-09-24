@php
    $action = $action ?? route('admin.faq.store');
    $method = $method ?? 'POST';
@endphp

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="flex flex-col space-y-1.5 p-6">
            <h2 class="text-2xl font-semibold leading-none tracking-tight">Informations</h2>
        </div>
        <div class="p-6 pt-0 space-y-4">
            <div class="space-y-1.5">
                <label for="question" class="text-sm font-medium">Question</label>
                <input id="question" type="text" name="question"
                       class="w-full h-10 px-3 rounded-md border border-input bg-background text-foreground placeholder:text-muted-foreground shadow-sm focus:outline-none focus:ring-2 focus:ring-ring transition"
                       required maxlength="255"
                       value="{{ old('question', $item->question ?? '') }}">
                @error('question')<p class="text-destructive text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-1.5">
                <label for="answer" class="text-sm font-medium">Réponse</label>
                <textarea id="answer" rows="8" name="answer"
                          class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                          required>{{ old('answer', $item->answer ?? '') }}</textarea>
                @error('answer')<p class="text-destructive text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label for="faq_category_id" class="text-sm font-medium">Catégorie</label>
                    <select id="faq_category_id" name="faq_category_id"
                            class="w-full h-10 px-3 rounded-md border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring">
                        <option value="">— Aucune</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('faq_category_id', $item->faq_category_id ?? null) == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('faq_category_id')<p class="text-destructive text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-1.5">
                    <label for="position" class="text-sm font-medium">Position</label>
                    <input id="position" type="number" name="position" min="0"
                           class="w-full h-10 px-3 rounded-md border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                           value="{{ old('position', $item->position ?? 0) }}">
                    @error('position')<p class="text-destructive text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-end">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="published" value="1"
                               @checked(old('published', $item->published ?? true))
                               class="h-4 w-4 text-primary bg-background border-border rounded focus:ring-primary focus:ring-2 focus:ring-offset-0 transition">
                        <span>Publié</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.faq.index') }}"
           class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground h-11 px-6">
            Annuler
        </a>
        <button type="submit"
                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-primary-foreground text-sm font-medium bg-primary hover:bg-primary/90 hover-glow-purple h-11 px-6">
            <i class="fas fa-save h-4 w-4"></i> Enregistrer
        </button>
    </div>
</form>
