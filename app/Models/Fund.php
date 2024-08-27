<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    public function categories(){
        return $this->belongsTo(FundCategory::class);
    }
    public function items(){
        return $this->hasMany(FundItem::class);
    }
}
