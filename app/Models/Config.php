<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    protected $fillable=['key','content','remark'];
    protected $casts=['content'=>'json'];

    public static function item($key){
        return Config::where('key',$key)->first()->content;
    }
}
