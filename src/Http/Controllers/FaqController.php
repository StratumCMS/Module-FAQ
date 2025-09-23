<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Faq\Models\FaqCategory;
use Modules\Faq\Models\FaqItem;

class FaqController extends Controller
{

    public function index()
    {
        $categories = FaqCategory::public()->orderBy('position')->with(['items' => fn($q) => $q->published()->orderBy('position')])->get();
        $items = FaqItem::published()->whereNull('faq_category_id')->orderBy('position')->get();
        return view('faq::index', compact('categories', 'items'));
    }

    public function category(?FaqCategory $category = null) {
        abort_if(!$category || !$category->is_public, 404);
        $category->load(['items' => fn($q) => $q->published()->orderBy('position')]);

        return view('faq::category', compact('category'));
    }
}
