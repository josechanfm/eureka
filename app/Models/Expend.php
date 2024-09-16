<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expend extends Model
{
    use HasFactory;
    protected $fillable=['year','fund_id','title','proposal_number','proposed_at','proposed_by','approved_at','remark','owner_id','creator_id','updater_id','status'];

    public function fund(){
        return $this->belongsTo(Fund::class);
    }

    public function items(){
        return $this->hasMany(ExpendItem::class);
    }
    public function setSubmitted(){
        $this->status='S3';
        $this->save();
        return $this->status;
    }
    // public function setReturned(){
    //     $this->status='S2';
    //     $this->save();
    //     return $this->status;
    // }
    // public function setAccepted(){
    //     $this->status='S4';
    //     $this->save();
    //     return $this->status;
    // }
    // public function setArchived(){
    //     $this->status='S5';
    //     $this->save();
    //     return $this->status;
    // }

}
