<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItemAccount extends Model
{
    use HasFactory;
    protected $fillable=['category_item_id','name_zh','name_en','name_pt','user_define','account_code'];

    public function item(){
        return $this->belongsTo(CategoryItem::class);
    }
}
