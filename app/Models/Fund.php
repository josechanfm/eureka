<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;
    protected $fillable=['entity','declarant','birm','project_code','title','responsible','amount','type','duration','grant','grants','repayment','repayments','created_by','updated_by'];
    protected $casts=['grants'=>'array','repayments'=>'array'];

    public function categories(){
        return $this->belongsTo(FundCategory::class);
    }
    public function items(){
        return $this->hasMany(FundItem::class)->with('accounts');
    }
}
