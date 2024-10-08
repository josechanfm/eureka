<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expend extends Model
{
    use HasFactory;

    protected $fillable=['budget_id','title','number','date','remark'];

    public function budget(){
        return $this->belongsTo(Budget::class);
    }

    public function items(){
        return $this->hasMany(ExpendItem::class);
    }
}
