<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpendItem extends Model
{
    use HasFactory;
    protected $fillable = ['expend_id','fund_item_split_id','account_code','description','amount','remark','creater_id','updater_id'];
    //protected $with=['account'];

    public function expend(){
        return $this->belongsTo(ExpendItem::class);
    }
    public function split(){
        return $this->bleongsTo(FundItemSplit::class);
    }
}
