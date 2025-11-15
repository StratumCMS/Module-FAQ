<?php

namespace Modules\Faq\Providers;

use App\Support\ModuleComponentRenderer;
use Illuminate\Support\ServiceProvider;
use Modules\Faq\Models\FaqCategory;
use Modules\Faq\Models\FaqItem;
use Modules\Faq\Support\FaqApi;

class FaqServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('plugin.faq', function () {
           return new FaqApi;
        });
    }

    public function boot(): void
    {

    }

    public function adminNavigation(): array
    {
        return [
            'faq' => [
                'name' => 'FAQ',
                'type' => 'dropdown',
                'icon' => 'fa-circle-question',
                'items' => [
                    'admin.faq.index' => ['name' => 'FAQ'],
                    'admin.faq.categories' => ['name' => 'Catégories'],
                ],
            ],
        ];
    }

    public function registerComponent(ModuleComponentRenderer $renderer): void
    {
        $renderer->register(
            'faq.list',
            'faq::components.faq-list',
            function () {
                return [
                    'faqs' => FaqItem::published()
                        ->orderBy('position', 'asc')
                        ->get()
                ];
            }
        );

        $renderer->register(
            'faq.carousel',
            'faq::components.faq-carousel',
            function () {
                return [
                    'faqs' => FaqItem::published()
                        ->orderBy('position', 'asc')
                        ->limit(5)
                        ->get()
                ];
            }
        );

        $renderer->register(
            'faq.by-category',
            'faq::components.faq-by-category',
            function () {
                return [
                    'categories' => FaqCategory::with(['items' => function($q) {
                        $q->published()->orderBy('position');
                    }])->orderBy('position')->get()
                ];
            }
        );

        $renderer->register(
            'faq.popular',
            'faq::components.faq-popular',
            function () {
                return [
                    'faqs' => FaqItem::published()
                        ->orderBy('views', 'desc')
                        ->limit(6)
                        ->get()
                ];
            }
        );
    }


}
