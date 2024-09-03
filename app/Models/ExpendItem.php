<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpendItem extends Model
{
    use HasFactory;
    protected $fillable=['expend_id','fund_item_account_id','description','amount','remark','creater_id','updater_id'];

    public function expend(){
        return $this->belongsTo(ExpendItem::class);
    }
}
