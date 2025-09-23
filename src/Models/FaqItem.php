<?php

namespace Modules\Faq\Models;

use Illuminate\Database\Eloquent\Model;

class FaqItem extends Model
{
    protected $guarded = [];

    protected $fillable = ['faq_category_id', 'question', 'answer', 'position', 'published'];

    public function category(){
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }

    public function scopePublished($query){
        return $query->where('published', true);
    }

}
