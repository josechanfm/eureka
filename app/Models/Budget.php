<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    protected $fillable=['category_id','fund_id','title','proposal_number','proposed_at','proposed_by','approved_at','remark','owner_id','creator_id','updater_id','status'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function fund(){
        return $this->belongsTo(Fund::class);
    }

    public function items(){
        return $this->hasMany(BudgetItem::class)->with('split')->with('expendItems');
    }
    public function expends(){
        return $this->hasMany(Expend::class);
    }
    public function setSubmitted(){
        $this->status='S3';
        $this->save();
        return $this->status;
    }
    public function canSubmit(){
        if($this->items()->where('account_code','GF')->count()>0){
            return false;
        }
        if($this->items()->where('account_code','')->orWhereNull('account_code')->count()>0){
            return false;
        }
        return true;
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
