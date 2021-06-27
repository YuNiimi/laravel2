<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datas extends Model
{
    use HasFactory;
    public $timestamps = false;

    public $fillable = ['store_id','slot_id','daiban','date','bb','rb','games'];

}
