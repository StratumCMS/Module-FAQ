<div class="faq-list-component py-12">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">Questions Fréquentes</h2>

        @if($faqs && $faqs->count() > 0)
            <div class="space-y-4">
                @foreach($faqs as $faq)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <details class="group">
                            <summary class="flex justify-between items-center p-6 cursor-pointer list-none">
                                <h3 class="text-lg font-semibold pr-4">{{ $faq->question }}</h3>
                                <span class="transition group-open:rotate-180">
                                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </summary>
                            <div class="px-6 pb-6 text-gray-600 dark:text-gray-300">
                                {!! $faq->answer !!}
                            </div>
                        </details>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500">Aucune question disponible pour le moment.</p>
        @endif
    </div>
</div>
