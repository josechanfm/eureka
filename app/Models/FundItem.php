<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundItem extends Model
{
    use HasFactory;
    protected $fillable=['fund_id','category_item_id','description','project_code','sequence','amount'];

    public function fund(){
        return $this->belongsTo(Fund::class);
    }

    public function accounts(){
        return $this->hasMany(FundItemAccount::class);
    }
}
