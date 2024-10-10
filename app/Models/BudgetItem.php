<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;
    protected $fillable = ['budget_id','fund_item_split_id','account_code','description','amount','remark','creator_id','updater_id'];
    //protected $with=['split','expends'];

    public function budget(){
        return $this->belongsTo(BudgetItem::class);
    }
    public function split(){
        return $this->belongsTo(FundItemSplit::class,'fund_item_split_id')->with('item');
    }
    public function expendItems(){
        return $this->hasMany(ExpendItem::class);
    }
}
