<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundItem extends Model
{
    use HasFactory;
    protected $fillable=['fund_id','category_item_id','sequence','description','project_code','sequence','amount'];
    protected $appends=['reserved'];

    public function getReservedAttribute(){
        $reserve=BudgetItem::whereIn('fund_item_split_id',$this->splits->pluck('id'))->sum('amount');
        $actual=BudgetItem::whereIn('fund_item_split_id',$this->splits->pluck('id'))->sum('actual');
        return $reserve-($reserve-$actual);
    }

    public function categoryItem(){
        return $this->belongsTo(CategoryItem::class);
    }
    public function fund(){
        return $this->belongsTo(Fund::class);
    }

    public function splits(){
        return $this->hasMany(FundItemSplit::class)->orderBy('sequence');
    }
}
