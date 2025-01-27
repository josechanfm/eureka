<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;
    protected $fillable=['year','category','entity','declarant','birm','project_code','title','responsible','amount','type','duration','grant','grants','repayment','repayments','created_by','updated_by'];
    protected $casts=['is_submitted'=>'boolean','grants'=>'array','repayments'=>'array','is_closed'=>'boolean'];
    
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
            $spends=$this->budgetItems->where('fund_item_split_id',$split->id)->sum('amount');
            $splits[$i]->available-=$spends;
        }
        return $splits;
    }
    public function budgets(){
        return $this->hasMany(Budget::class);
    }
    public function budgetItems(){
        return $this->hasManyThrough(BudgetItem::class, Budget::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function isMember(){
        return in_array(auth()->user()->id,$this->users->pluck('id')->toArray());
    }
    public function ownedBy(){
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function summary(){
        $items=$this->items;
        foreach($items as $item){
            foreach($item->splits as $split){
                $split->reserved=BudgetItem::where('fund_item_split_id',$split->id)->sum('amount');
            }
        }
        return $items;
    }
}
