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
        return ExpendItem::whereIn('fund_item_split_id',$this->splits->pluck('id'))->sum('amount');
    }

    public function fund(){
        return $this->belongsTo(Fund::class);
    }

    public function splits(){
        return $this->hasMany(FundItemSplit::class)->orderBy('sequence');
    }
}
