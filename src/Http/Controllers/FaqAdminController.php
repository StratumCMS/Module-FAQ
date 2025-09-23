<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Faq\Events\FaqItemCreated;
use Modules\Faq\Events\FaqItemDeleted;
use Modules\Faq\Events\FaqItemUpdated;
use Modules\Faq\Models\FaqCategory;
use Modules\Faq\Models\FaqItem;

class FaqAdminController extends Controller
{
    public function index()
    {
        $items = FaqItem::orderBy('position')->paginate(25);
        return view('faq::admin.index', compact('items'));
    }

    public function create() {
        $categories = FaqCategory::orderBy('position')->get();
        return view('faq::admin.create', compact('categories'));
    }

    public function store(Request $request){
        $data = $request->validate([
           'faq_category_id' => ['nullable', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
            'published' => ['nullable', 'boolean'],
        ]);
        $item = FaqItem::create($data + ['published' => (bool)($data['published'] ?? false)]);
        event(new FaqItemCreated($item));
        return redirect()->route('admin.faq.index')->with('status', 'FAQ créée.');
    }

    public function edit(FaqItem $item){
        $categories = FaqCategory::orderBy('position')->get();
        return view('faq::admin.edit', compact('item', 'categories'));
    }

    public function update(Request $request, FaqItem $item){
        $data = $request->validate([
           'faq_category_id' => ['nullable', 'exists:faq_categories,id'],
           'question' => ['required', 'string', 'max:255'],
           'answer' => ['required', 'string'],
           'position' => ['nullable', 'integer', 'min:0'],
           'published' => ['nullable', 'boolean'],
        ]);
        $item->update($data + ['published' => (bool)($data['published'] ?? false)]);
        event(new FaqItemUpdated($item));
        return redirect()->route('admin.faq.index')->with('status', 'FAQ mis à jour.');
    }

    public function  destroy(FaqItem $item){
        $item->delete();
        event(new FaqItemDeleted($item->id));
        return back()->with('status', 'FAQ supprimée.');
    }

    public function categories(){
        $categories = FaqCategory::orderBy('position')->get();
        return view('faq::admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'alpha_dash', 'max:100', 'unique:faq_categories,slug'],
            'position' => ['nullable', 'integer', 'min:0'],
            'is_public' => ['nullable', 'boolean'],
        ]);
        FaqCategory::create($data + ['is_public' => (bool)($data['is_public'] ?? true)]);
        return back()->with('status', 'Catégorie créée.');
    }

    public function updateCategory(Request $request, FaqCategory $category){
        $data = $request->validate([
           'name' => ['required', 'string', 'max:100'],
           'slug' => ['required', 'alpha_dash', 'max:100', 'unique:faq_categories,slug,'.$category->id],
            'position' => ['nullable', 'integer', 'min:0'],
            'is_public' => ['nullable', 'boolean'],
        ]);
        $category->update($data + ['is_public' => (bool)($data['is_public'] ?? true)]);
        return back()->with('status', 'Catégorie mise à jour');
    }

    public function destroyCategory(FaqCategory $category){
        $category->delete();
        return back()->with('status', 'Catégorie supprimée.');
    }
}
