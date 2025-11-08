@extends('admin.layouts.admin')
@section('title', 'FAQ')

@section('content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold sm:text-3xl">FAQ</h1>
                    <p class="text-sm text-muted-foreground mt-1">Gérez les questions fréquentes</p>
                </div>
                <a href="{{ route('admin.faq.categories') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-border bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
                    <i class="fa-solid fa-folder mr-2"></i>
                    <span>Gérer les catégories</span>
                </a>
            </div>
        </div>

        @if(session('status'))
            <div class="mb-6 rounded-xl border-l-4 border-green-500 bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/20 dark:text-green-400">
                <div class="flex items-start">
                    <i class="fa-solid fa-circle-check mr-3 mt-0.5"></i>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-xl border border-border bg-card p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                                <i class="fa-solid fa-circle-question text-primary"></i>
                            </div>
                            <div>
                                <p class="text-sm text-muted-foreground">Total FAQ</p>
                                <p class="text-2xl font-semibold">{{ $items->total() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-xl border border-border bg-card p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                                <i class="fa-solid fa-check text-green-600 dark:text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-muted-foreground">Publiées</p>
                                <p class="text-2xl font-semibold">{{ $items->where('published', true)->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 lg:hidden">
                    @forelse($items as $item)
                        <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm hover:shadow-md">
                            <div class="p-4">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-medium text-base">{{ $item->question }}</h3>
                                        <p class="text-xs text-muted-foreground mt-1">
                                            <i class="fa-solid fa-folder mr-1"></i>
                                            <span>{{ optional($item->category)->name ?? 'Sans catégorie' }}</span>
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center ml-3">
                                        <i class="fa-solid {{ $item->published ? 'fa-circle-check text-green-600 dark:text-green-400' : 'fa-circle-xmark text-gray-500 dark:text-gray-400' }} text-base"></i>
                                    </span>
                                </div>

                                <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-muted/50 px-3 py-1 text-sm">
                                    <i class="fa-solid fa-arrow-up-1-9 text-muted-foreground text-xs"></i>
                                    <span class="text-muted-foreground">Position :</span>
                                    <strong>{{ $item->position }}</strong>
                                </div>

                                <div class="flex gap-2 border-t border-border pt-3 mt-3">
                                    <button
                                        class="flex-1 inline-flex items-center justify-center rounded-lg bg-primary/10 px-3 py-2.5 text-sm font-medium text-primary hover:bg-primary/20 transition-colors"
                                        onclick="openEditModal(this)"
                                        data-id="{{ $item->id }}"
                                        data-question="{{ $item->question }}"
                                        data-answer="{{ $item->answer }}"
                                        data-category_id="{{ $item->faq_category_id }}"
                                        data-position="{{ $item->position }}"
                                        data-published="{{ $item->published }}">
                                        <i class="fa-solid fa-pen mr-2"></i>
                                        Modifier
                                    </button>
                                    <form action="{{ route('admin.faq.destroy', $item) }}" method="POST" class="flex-1" onsubmit="return confirm('Supprimer cette FAQ ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center rounded-lg bg-destructive/10 px-3 py-2.5 text-sm font-medium text-destructive hover:bg-destructive/20 transition-colors">
                                            <i class="fa-solid fa-trash mr-2"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-border bg-card p-12 text-center shadow-sm">
                            <div class="flex flex-col items-center">
                                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-muted/50">
                                    <i class="fa-solid fa-inbox text-3xl text-muted-foreground/50"></i>
                                </div>
                                <p class="text-sm text-muted-foreground mb-1 font-medium">Aucune FAQ</p>
                                <p class="text-xs text-muted-foreground">Commencez par créer votre première FAQ</p>
                            </div>
                        </div>
                    @endforelse
                </div>

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
                                <td class="px-6 py-4 text-sm text-muted-foreground text-center align-middle">
                                    <span class="inline-flex items-center gap-1.5 rounded-md bg-muted/50 px-2 py-1 text-xs">
                                        <i class="fa-solid fa-folder text-[10px] mr-1"></i>
                                        {{ optional($item->category)->name ?? 'Sans catégorie' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-center align-middle">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-muted/50 px-3 py-1 font-medium">
                                        <i class="fa-solid fa-arrow-up-1-9 text-[10px] text-muted-foreground mr-1"></i>
                                        {{ $item->position }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center align-middle">
                                    <span class="inline-flex items-center justify-center">
                                        <i class="fa-solid {{ $item->published ? 'fa-circle-check text-green-600 dark:text-green-400' : 'fa-circle-xmark text-gray-500 dark:text-gray-400' }} text-base"></i>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center align-middle">
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3"
                                            onclick="openEditModal(this)"
                                            data-id="{{ $item->id }}"
                                            data-question="{{ $item->question }}"
                                            data-answer="{{ $item->answer }}"
                                            data-category_id="{{ $item->faq_category_id }}"
                                            data-position="{{ $item->position }}"
                                            data-published="{{ $item->published }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <form action="{{ route('admin.faq.destroy', $item) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette FAQ ? Cette action est irréversible.')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-destructive/10 h-9 px-3 text-destructive">
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
                                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-muted/50">
                                            <i class="fa-solid fa-inbox text-3xl text-muted-foreground/50"></i>
                                        </div>
                                        <p class="text-sm text-muted-foreground mb-1 font-medium">Aucune FAQ</p>
                                        <p class="text-xs text-muted-foreground">Commencez par créer votre première FAQ</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if($items->hasPages())
                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>
                @endif
            </div>

            <div class="lg:col-span-1">
                <div class="rounded-xl border border-border bg-card shadow-sm overflow-hidden sticky top-6">
                    <div class="border-b border-border bg-muted/50 px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10">
                                <i class="fa-solid fa-plus text-primary text-sm"></i>
                            </div>
                            <h2 class="font-semibold">Créer une FAQ</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.faq.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="space-y-2">
                                <label class="text-sm font-medium flex items-center gap-2">
                                    <i class="fa-solid fa-circle-question text-muted-foreground text-xs"></i>
                                    Question
                                </label>
                                <input type="text" name="question"
                                       class="w-full h-11 px-4 rounded-lg border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring text-base transition-all"
                                       value="{{ old('question') }}"
                                       required
                                       maxlength="255"
                                       placeholder="Ex: Comment réinitialiser mon mot de passe ?">
                                @error('question') <p class="text-destructive text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium flex items-center gap-2">
                                    <i class="fa-solid fa-message text-muted-foreground text-xs"></i>
                                    Réponse
                                </label>
                                <textarea name="answer" rows="4"
                                          class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring text-base transition-all resize-none"
                                          required
                                          placeholder="Écrivez la réponse ici...">{{ old('answer') }}</textarea>
                                @error('answer') <p class="text-destructive text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium flex items-center gap-2">
                                    <i class="fa-solid fa-folder text-muted-foreground text-xs"></i>
                                    Catégorie
                                </label>
                                <select name="faq_category_id"
                                        class="w-full h-11 px-4 rounded-lg border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all">
                                    <option value="">Sans catégorie</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" @selected(old('faq_category_id') == $cat->id)>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('faq_category_id') <p class="text-destructive text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium flex items-center gap-2">
                                    <i class="fa-solid fa-arrow-up-1-9 text-muted-foreground text-xs"></i>
                                    Position
                                </label>
                                <input type="number" min="0" name="position"
                                       class="w-full h-11 px-4 rounded-lg border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring text-base transition-all"
                                       value="{{ old('position', 0) }}"
                                       placeholder="0">
                                @error('position') <p class="text-destructive text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium flex items-center gap-2">
                                    <i class="fa-solid fa-eye text-muted-foreground text-xs"></i>
                                    Publication
                                </label>
                                <div class="rounded-lg border border-input bg-background p-3">
                                    <label class="inline-flex items-center gap-3 cursor-pointer group">
                                        <div class="relative">
                                            <input type="checkbox" name="published" value="1" @checked(old('published', true)) class="sr-only peer">
                                            <div class="w-11 h-6 bg-muted rounded-full peer peer-checked:bg-primary transition-colors"></div>
                                            <div class="absolute left-1 top-1 bg-background w-4 h-4 rounded-full transition-transform peer-checked:translate-x-5 shadow-sm"></div>
                                        </div>
                                        <span class="text-sm font-medium">Publier la FAQ</span>
                                    </label>
                                </div>
                            </div>
                            <div class="pt-2">
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-primary-foreground transition-all hover:bg-primary/90 hover:shadow-md">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Créer la FAQ</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="relative bg-card w-full sm:max-w-lg sm:rounded-xl rounded-xl border-t sm:border border-border shadow-2xl max-h-[90vh] sm:max-h-[85vh] flex flex-col animate-slide-up sm:animate-fade-in">
                <div class="border-b border-border sm:rounded-xl rounded-xl bg-muted/50">
                    <div class="sm:hidden flex justify-center pt-3 pb-2">
                        <div class="w-12 h-1.5 bg-muted-foreground/30 rounded-full"></div>
                    </div>

                    <div class="px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="hidden sm:flex w-10 h-10 rounded-lg bg-primary/10 items-center justify-center">
                                <i class="fa-solid fa-pen text-primary"></i>
                            </div>
                            <div>
                                <h2 class="font-semibold text-base sm:text-lg">Modifier la FAQ</h2>
                                <p class="text-xs text-muted-foreground hidden sm:block">Mettez à jour les informations</p>
                            </div>
                        </div>
                        <button onclick="closeEditModal()"
                                class="flex items-center justify-center w-9 h-9 rounded-lg hover:bg-muted transition-colors text-muted-foreground hover:text-foreground"
                                aria-label="Fermer">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto overscroll-contain">
                    <div class="p-4 sm:p-6">
                        <form id="editForm" method="POST" class="space-y-4">
                            @csrf @method('PUT')
                            <div class="space-y-2">
                                <label for="edit_question" class="text-sm font-medium flex items-center gap-2">
                                    <i class="fa-solid fa-circle-question text-muted-foreground text-xs"></i>
                                    Question
                                </label>
                                <input type="text"
                                       id="edit_question"
                                       name="question"
                                       class="w-full h-11 px-4 rounded-lg border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all text-base"
                                       required
                                       maxlength="255"
                                       placeholder="Ex: Comment réinitialiser mon mot de passe ?">
                            </div>

                            <div class="space-y-2">
                                <label for="edit_answer" class="text-sm font-medium flex items-center gap-2">
                                    <i class="fa-solid fa-message text-muted-foreground text-xs"></i>
                                    Réponse
                                </label>
                                <textarea id="edit_answer"
                                          name="answer"
                                          rows="4"
                                          class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all resize-none text-base"
                                          required
                                          placeholder="Écrivez la réponse ici..."></textarea>
                            </div>

                            <div class="space-y-2">
                                <label for="edit_faq_category_id" class="text-sm font-medium flex items-center gap-2">
                                    <i class="fa-solid fa-folder text-muted-foreground text-xs"></i>
                                    Catégorie
                                </label>
                                <select id="edit_faq_category_id"
                                        name="faq_category_id"
                                        class="w-full h-11 px-4 rounded-lg border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all">
                                    <option value="">Sans catégorie</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="edit_position" class="text-sm font-medium flex items-center gap-2">
                                    <i class="fa-solid fa-arrow-up-1-9 text-muted-foreground text-xs"></i>
                                    Position
                                </label>
                                <input type="number"
                                       min="0"
                                       id="edit_position"
                                       name="position"
                                       class="w-full h-11 px-4 rounded-lg border border-input bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all text-base">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-medium flex items-center gap-2">
                                    <i class="fa-solid fa-eye text-muted-foreground text-xs"></i>
                                    Publication
                                </label>
                                <div class="rounded-lg border border-input bg-background p-3">
                                    <label class="inline-flex items-center gap-3 cursor-pointer group">
                                        <div class="relative">
                                            <input type="checkbox"
                                                   id="edit_published"
                                                   name="published"
                                                   value="1"
                                                   class="sr-only peer">
                                            <div class="w-11 h-6 bg-muted rounded-full peer peer-checked:bg-primary transition-colors"></div>
                                            <div class="absolute left-1 top-1 bg-background w-4 h-4 rounded-full transition-transform peer-checked:translate-x-5 shadow-sm"></div>
                                        </div>
                                        <span class="text-sm font-medium">Publier la FAQ</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="border-t border-border sm:rounded-xl rounded-xl bg-muted/50 p-4 sm:p-6">
                    <div class="flex flex-col-reverse sm:flex-row gap-3">
                        <button type="button"
                                onclick="closeEditModal()"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center rounded-lg border border-border bg-background px-6 py-3 sm:py-2.5 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
                            Annuler
                        </button>
                        <button type="submit"
                                form="editForm"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 sm:py-2.5 text-sm font-medium text-primary-foreground transition-all hover:bg-primary/90 hover:shadow-md">
                            <i class="fa-solid fa-check"></i>
                            <span>Enregistrer</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openEditModal(button) {
                const modal = document.getElementById('editModal');
                const form = document.getElementById('editForm');

                const data = {
                    id: button.dataset.id,
                    question: button.dataset.question,
                    answer: button.dataset.answer,
                    category_id: button.dataset.category_id,
                    position: button.dataset.position,
                    published: button.dataset.published === "1",
                };

                form.action = '{{ route("admin.faq.update", ":id") }}'.replace(':id', data.id);
                document.getElementById('edit_question').value = data.question;
                document.getElementById('edit_answer').value = data.answer;
                document.getElementById('edit_faq_category_id').value = data.category_id || '';
                document.getElementById('edit_position').value = data.position;
                document.getElementById('edit_published').checked = data.published;

                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                setTimeout(() => {
                    document.getElementById('edit_question').focus();
                    document.getElementById('edit_question').select();
                }, 150);
            }

            function closeEditModal() {
                const modal = document.getElementById('editModal');
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }

            document.getElementById('editModal')?.addEventListener('click', function(e) {
                if (e.target === this || e.target.classList.contains('backdrop-blur-sm')) {
                    closeEditModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const modal = document.getElementById('editModal');
                    if (!modal.classList.contains('hidden')) {
                        closeEditModal();
                    }
                }
            });

            let startY = 0;
            let currentY = 0;
            const modalContent = document.getElementById('editModal')?.querySelector('.relative');

            modalContent?.addEventListener('touchstart', (e) => {
                startY = e.touches[0].clientY;
            }, { passive: true });

            modalContent?.addEventListener('touchmove', (e) => {
                currentY = e.touches[0].clientY;
                const diff = currentY - startY;

                if (diff > 0 && window.scrollY === 0) {
                    e.preventDefault();
                    modalContent.style.transform = `translateY(${diff}px)`;
                    modalContent.style.opacity = 1 - (diff / 500);
                }
            }, { passive: false });

            modalContent?.addEventListener('touchend', () => {
                const diff = currentY - startY;

                if (diff > 100) {
                    closeEditModal();
                }

                modalContent.style.transform = '';
                modalContent.style.opacity = '';
                startY = 0;
                currentY = 0;
            });
        </script>

        <style>
            @keyframes slide-up {
                from { transform: translateY(100%); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            @keyframes fade-in {
                from { opacity: 0; transform: scale(0.95); }
                to { opacity: 1; transform: scale(1); }
            }
            .animate-slide-up { animation: slide-up 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
            .animate-fade-in { animation: fade-in 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
            .overscroll-contain { overscroll-behavior: contain; }
        </style>
    @endpush
@endsection
