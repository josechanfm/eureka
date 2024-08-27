<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundCategoryItem extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(FundCategory::class);
    }
}
