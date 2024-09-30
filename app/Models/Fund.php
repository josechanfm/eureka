<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;
    protected $fillable=['category_id','entity','declarant','birm','project_code','title','responsible','amount','type','duration','grant','grants','repayment','repayments','created_by','updated_by'];
    protected $casts=['grants'=>'array','repayments'=>'array','is_closed'=>'boolean'];
    
    public function category(){
        return $this->belongsTo(Category::class)->with('items');
    }
    public function items(){
        return $this->hasMany(FundItem::class)->with('splits')->orderBy('sequence');
    }
    public function splits(){
        return $this->hasManyThrough(FundItemSplit::class, FundItem::class);
    }
    public function availableSplits(){
        $splits=$this->hasManyThrough(FundItemSplit::class, FundItem::class)->with('item')->get();
        foreach($splits as $i=>$split){
            $splits[$i]->available=$split->amount??$split->item->amount;
        }
        ;
        foreach($splits as $i=>$split){
            $spends=$this->expendItems->where('fund_item_split_id',$split->id)->sum('amount');
            $splits[$i]->available-=$spends;
        }
        return $splits;
    }
    public function expends(){
        return $this->hasMany(Expend::class);
    }
    public function expendItems(){
        return $this->hasManyThrough(ExpendItem::class, Expend::class);
    }
    public function ownedBy(){
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function summary(){
        $items=$this->items;
        foreach($items as $item){
            foreach($item->splits as $split){
                $split->reserved=ExpendItem::where('fund_item_split_id',$split->id)->sum('amount');
            }
        }
        return $items;
    }
}
