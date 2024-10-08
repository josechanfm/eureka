<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpendItem extends Model
{
    use HasFactory;

    protected $fillable=['expend_id','description','amount','remark'];

    public function expend(){
        return $this->belongsTo(Expend::class);
    }
}
