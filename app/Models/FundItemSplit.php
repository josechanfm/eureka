<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundItemSplit extends Model
{
    use HasFactory;
    protected $table='fund_item_splits';

    protected $fillable=['fund_item_id','sequence','description','account_code','amount'];

    public function item(){
        return $this->belongsTo(FundItem::class,'fund_item_id');
    }

    public function expendItems(){
        return $this->hasMany(ExpendItem::class);
    }
}
