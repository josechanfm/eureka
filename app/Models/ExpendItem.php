<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpendItem extends Model
{
    use HasFactory;

    protected $fillable=['expend_id','budget_item_id','description','amount','remark'];
    //protected $with=['budgetItem'];

    public function expend(){
        return $this->belongsTo(Expend::class);
    }
    // public function budgetItem(){
    //     return $this->belongsTo(BudgetItem::class);
    // }
}
