<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundItem extends Model
{
    use HasFactory;
    protected $fillable=['fund_id','category_item_id','sequence','description','project_code','sequence','amount'];
    protected $appends=['budgeted'];

    public function getBudgetedAttribute(){
        return ExpendItem::where('fund_item_split_id',$this->id)->sum('amount');
    }

    public function fund(){
        return $this->belongsTo(Fund::class);
    }

    public function splits(){
        return $this->hasMany(FundItemSplit::class)->orderBy('sequence');
    }
}
