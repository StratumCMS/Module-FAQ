<?php

namespace Modules\Faq\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $guarded = [];

    protected $fillable = ['name', 'slug', 'position', 'is_public'];

    public function items(){
        return $this->hasMany(FaqItem::class)->orderBy('position');
    }

    public function scopePublic($query){
        return $query->where('is_public', true);
    }

}
