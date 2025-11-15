<div class="faq-by-category-component py-12">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">FAQ par Catégorie</h2>

        @if($categories && $categories->count() > 0)
            <div class="space-y-12">
                @foreach($categories as $category)
                    @if($category->faqs && $category->faqs->count() > 0)
                        <div class="category-section">
                            <h3 class="text-2xl font-bold mb-6 text-primary border-b-2 border-primary pb-2">
                                {{ $category->name }}
                            </h3>

                            @if($category->description)
                                <p class="text-gray-600 dark:text-gray-300 mb-6">{{ $category->description }}</p>
                            @endif

                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach($category->faqs as $faq)
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                                        <h4 class="font-semibold mb-2 flex items-start">
                                            <svg class="w-5 h-5 text-primary mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $faq->question }}
                                        </h4>
                                        <div class="text-sm text-gray-600 dark:text-gray-300 ml-7">
                                            {!! Str::limit(strip_tags($faq->answer), 150) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500">Aucune catégorie disponible.</p>
        @endif
    </div>
</div>
