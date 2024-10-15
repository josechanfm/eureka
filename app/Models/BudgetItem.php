<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;
    protected $fillable = ['budget_id','fund_item_split_id','category_item_account_id','account_code','description','amount','remark','creator_id','updater_id'];
    protected $casts=['user_define'=>'boolean'];
    //protected $with=['split','expends'];
    protected $appends=['category_item_account_code'];

    public function getCategoryItemAccountCodeAttribute(){
        $account=CategoryItemAccount::find($this->category_item_account_id);
        //dd($account);
        if($account){
            if($account->user_define){
                return $this->account_code;
            }else{
                return $account->account_code;
            };
        }else{
            return null;
        }
        //return CategoryItemAccount::find($this->category_item_account_id)?->account_code;
    }
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
