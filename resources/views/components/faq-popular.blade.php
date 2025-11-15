<div class="faq-popular-component py-12 bg-gradient-to-br from-primary/10 to-purple-500/10">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-2 bg-primary/20 text-primary rounded-full text-sm font-semibold mb-4">
                🔥 Les Plus Consultées
            </span>
            <h2 class="text-3xl font-bold">Questions Populaires</h2>
        </div>

        @if($faqs && $faqs->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($faqs as $index => $faq)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-2xl transition-shadow duration-300">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                <span class="text-primary font-bold text-lg">#{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold mb-2 text-lg">{{ $faq->question }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3">
                                    {{ strip_tags($faq->answer) }}
                                </p>
                                <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ number_format($faq->views ?? 0) }} vues
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500">Aucune question populaire pour le moment.</p>
        @endif
    </div>
</div>
