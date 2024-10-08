<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundItemSplit extends Model
{
    use HasFactory;
    protected $table='fund_item_splits';

    protected $fillable=['fund_item_id','sequence','description','account_code','amount'];
    protected $appends=['reserved'];
    
    public function getReservedAttribute(){
        return BudgetItem::where('fund_item_split_id',$this->id)->sum('amount');
    }

    public function item(){
        return $this->belongsTo(FundItem::class,'fund_item_id');
    }

    public function budgetItems(){
        return $this->hasMany(BudgetItem::class);
    }
}
