<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundItemAccount extends Model
{
    use HasFactory;
    protected $fillable=['category_item_account_id','fund_item_id','description','account_code','amount'];

    public function item(){
        return $this->belongsTo(FundItem::class,'fund_item_id');
    }
}
