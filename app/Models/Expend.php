<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expend extends Model
{
    use HasFactory;
    protected $fillable=['year','fund_id','title','proposal_number','proposed_at','proposed_by','approved_at','remark','owner_id','creator_id','updater_id','is_submitted'];
    protected $casts=['is_locked'=>'boolean','is_closed'=>'boolean'];

    public function fund(){
        return $this->belongsTo(Fund::class);
    }

    public function items(){
        return $this->hasMany(ExpendItem::class);
    }
}
