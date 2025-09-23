<?php

namespace Modules\Faq\Support;

use Modules\Faq\Models\FaqCategory;
use Modules\Faq\Models\FaqItem;

class FaqApi{

    /*
        Catégories filtré avec leur items
    */
    public function categoriesWithItems(bool $onlyPublic = true){
        return FaqCategory::query()
            ->when($onlyPublic, fn($q) => $q->where('is_public', true))
            ->orderBy('position')
            ->with([
                'items' => function($q) use ($onlyPublic){
                $q->orderBy('position');
                if ($onlyPublic){
                    $q->where('is_public', true);
                }
            }
            ])
            ->get();
    }


    /* Items sans catégories */
    public function uncategorized(bool $onlyPublic = true){
        return FaqItem::query()
            ->whereNull('faq_category_id')
            ->when($onlyPublic, fn($q) => $q->where('published', true))
            ->orderBy('position')
            ->get();
    }

    /*
        Tout groupé en bloc distinct :
        categories + items
        items (sans catégories)
    */
    public function allGrouped(bool $onlyPublic = true){
        $groups = collect();

        $categories = $this->categoriesWithItems($onlyPublic);
        foreach ($categories as $category){
            $groups->push([
                'category' => $category,
                'items' => $category->items->sortBy('position')->values(),
                ]);
        }

        $orphans = $this->uncategorized($onlyPublic);
        if ($orphans->isNotEmpty()){
            $groups->push([
                'category' => null,
                'items' => $orphans->values(),
            ]);
        }

        return $groups;
    }

    /*

        Liste plat des items (catégories eager-load)

    */
    public function itemsFlat(bool $onlyPublic = true)
    {
        return FaqItem::query()
            ->when($onlyPublic, function ($q) {
                $q->where('published', true)
                    ->where(function ($q2) {
                        $q2->whereNull('faq_category_id')
                            ->orWhereHas('category', fn($c) => $c->where('is_public', true));
                    });
            })
            ->with(['category:id,name,slug,position,is_public'])
            ->orderBy('position')
            ->get();
    }

    /*

        Search :
    retourne items, avec catégorie eager-load

    */
    public function search(string $term, int $limit = 10, bool $onlyPublic = true)
    {
        $like = "%{$term}%";

        return FaqItem::query()
            ->where(function ($q) use ($like) {
                $q->where('question', 'like', $like)
                    ->orWhere('answer', 'like', $like);
            })
            ->when($onlyPublic, function ($q) {
                $q->where('published', true)
                    ->where(function ($q2) {
                        $q2->whereNull('faq_category_id')
                            ->orWhereHas('category', fn($c) => $c->where('is_public', true));
                    });
            })
            ->with(['category:id,name,slug,position,is_public'])
            ->orderBy('position')
            ->limit($limit)
            ->get();
    }

}
