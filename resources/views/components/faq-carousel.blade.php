<!-- Splide CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">

<div class="faq-carousel-component py-16 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">
                Questions Fréquentes
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-lg">
                Trouvez rapidement les réponses à vos questions
            </p>
        </div>

        @if($faqs && $faqs->count() > 0)
            <div class="relative splide-wrapper">
                <div class="splide" id="faqSplide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach($faqs as $index => $faq)
                                <li class="splide__slide px-3">
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 p-6 sm:p-8 h-full border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 group">
                                        <!-- Question Icon -->
                                        <div class="flex items-start gap-4 mb-4">
                                            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white leading-tight flex-1">
                                                {{ $faq->question }}
                                            </h3>
                                        </div>

                                        <!-- Answer -->
                                        <div class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4 pl-16">
                                            {!! Str::limit(strip_tags($faq->answer), 180) !!}
                                        </div>

                                        @if(strlen(strip_tags($faq->answer)) > 180)
                                            <button class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold inline-flex items-center gap-2 group/link pl-16">
                                                Lire la suite
                                                <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Custom Navigation Buttons -->
                <button class="splide-prev hidden lg:flex absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-12 h-12 bg-white dark:bg-gray-800 rounded-full shadow-lg items-center justify-center text-gray-800 dark:text-gray-200 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 transition-all duration-300 z-10" aria-label="Précédent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="splide-next hidden lg:flex absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-12 h-12 bg-white dark:bg-gray-800 rounded-full shadow-lg items-center justify-center text-gray-800 dark:text-gray-200 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 transition-all duration-300 z-10" aria-label="Suivant">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Custom Dots -->
                <div class="flex justify-center gap-2 mt-8 splide-dots"></div>
            </div>

            <style>
                /* Hide default Splide arrows */
                .splide__arrows { display: none !important; }

                /* Hide default pagination */
                .splide__pagination { display: none !important; }

                /* Smooth transitions */
                .splide__slide {
                    opacity: 1;
                    transition: opacity 0.3s;
                }

                /* Ensure slides have proper height */
                .splide__slide > div {
                    height: 100%;
                }
            </style>

            <!-- Splide JS -->
            <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
            <script>
                (function() {
                    // Wait for Splide to be loaded
                    function initCarousel() {
                        if (typeof Splide === 'undefined') {
                            console.error('Splide is not loaded!');
                            setTimeout(initCarousel, 100);
                            return;
                        }

                        console.log('Initializing Splide carousel...');

                        const splide = new Splide('#faqSplide', {
                            type: 'loop',
                            perPage: 3,
                            perMove: 1,
                            gap: '1rem',
                            padding: '1rem',
                            autoplay: true,
                            interval: 4000,
                            pauseOnHover: true,
                            pauseOnFocus: true,
                            resetProgress: false,
                            arrows: false,
                            pagination: false,
                            drag: true,
                            flickPower: 300,
                            flickMaxPages: 1,
                            speed: 600,
                            easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
                            breakpoints: {
                                1024: {
                                    perPage: 3,
                                    gap: '1rem',
                                },
                                640: {
                                    perPage: 2,
                                    gap: '0.75rem',
                                    padding: '0.5rem',
                                },
                                480: {
                                    perPage: 1,
                                    gap: '0.5rem',
                                    padding: '0.25rem',
                                }
                            }
                        });

                        splide.mount();
                        console.log('Splide mounted successfully!');

                        // Custom navigation
                        const prevBtn = document.querySelector('.splide-prev');
                        const nextBtn = document.querySelector('.splide-next');

                        if (prevBtn) {
                            prevBtn.addEventListener('click', () => {
                                splide.go('<');
                            });
                        }

                        if (nextBtn) {
                            nextBtn.addEventListener('click', () => {
                                splide.go('>');
                            });
                        }

                        // Custom dots
                        const dotsContainer = document.querySelector('.splide-dots');
                        const totalSlides = {{ $faqs->count() }};

                        // Create dots
                        function createDots() {
                            dotsContainer.innerHTML = '';
                            const slidesToShow = splide.options.perPage;
                            const maxDots = Math.ceil(totalSlides / slidesToShow);

                            for (let i = 0; i < maxDots; i++) {
                                const dot = document.createElement('button');
                                dot.className = 'w-3 h-3 rounded-full transition-all duration-300 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500';
                                dot.setAttribute('aria-label', `Aller à la page ${i + 1}`);
                                dot.addEventListener('click', () => {
                                    splide.go(i * slidesToShow);
                                });
                                dotsContainer.appendChild(dot);
                            }
                            updateDots();
                        }

                        // Update active dot
                        function updateDots() {
                            const dots = dotsContainer.querySelectorAll('button');
                            const currentIndex = splide.index;
                            const slidesToShow = splide.options.perPage;
                            const activeDot = Math.floor(currentIndex / slidesToShow);

                            dots.forEach((dot, index) => {
                                if (index === activeDot) {
                                    dot.className = 'w-8 h-3 rounded-full transition-all duration-300 bg-blue-600';
                                } else {
                                    dot.className = 'w-3 h-3 rounded-full transition-all duration-300 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500';
                                }
                            });
                        }

                        createDots();
                        splide.on('moved', updateDots);
                        splide.on('resized', () => {
                            createDots();
                        });
                    }

                    // Initialize when DOM is ready
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', initCarousel);
                    } else {
                        initCarousel();
                    }
                })();
            </script>
        @else
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-lg">Aucune question disponible pour le moment.</p>
            </div>
        @endif
    </div>
</div>
