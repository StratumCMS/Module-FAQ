<?php

namespace Modules\Faq\Providers;

use Illuminate\Support\ServiceProvider;
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
                    'admin.faq.index' => ['name' => 'Liste'],
                    'admin.faq.create' => ['name' => 'Nouveau'],
                    'admin.faq.categories' => ['name' => 'Catégories'],
                ],
            ],
        ];
    }
}
