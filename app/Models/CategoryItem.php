<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;
    protected $fillable=['category_id','name_zh','name_en','name_pt','account_code'];
    protected $casts=['user_define'=>'boolean'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function accounts(){
        return $this->hasMany(CategoryItemAccount::class);
    }
}
