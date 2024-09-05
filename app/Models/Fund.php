<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;
    protected $fillable=['fund_category_id','entity','declarant','birm','project_code','title','responsible','amount','type','duration','grant','grants','repayment','repayments','created_by','updated_by'];
    protected $casts=['grants'=>'array','repayments'=>'array','is_closed'=>'boolean'];

    public function category(){
        return $this->belongsTo(Category::class)->with('items');
    }
    public function items(){
        return $this->hasMany(FundItem::class)->with('accounts');
    }
    public function accounts(){
        return $this->hasManyThrough(FundItemAccount::class, FundItem::class);
    }
    public function availableAccounts(){
        $accounts=$this->hasManyThrough(FundItemAccount::class, FundItem::class)->with('item')->get();
        foreach($accounts as $i=>$account){
            $accounts[$i]->available=$account->amount??$account->item->amount;
        }
        ;
        foreach($accounts as $i=>$account){
            $spends=$this->expendItems->where('fund_item_account_id',$account->id)->sum('amount');
            $accounts[$i]->available-=$spends;
        }
        return $accounts;
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
            foreach($item->accounts as $account){
                $account->total=ExpendItem::where('fund_item_account_id',$account->id)->sum('amount');
            }
        }
        return $items;
    }
}
