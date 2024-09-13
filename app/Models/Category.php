<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable=['type','version','title_zh','title_en','title_pt','remark','active'];

    public static function latestVersion($type,$year){
        return Category::where('type',$type)->where('version','<=',$year)->where('active',true)->orderBy('version','DESC')->first();

    }
    public function items(){
        return $this->hasMany(CategoryItem::class)->with('accounts');
    }
    
}
