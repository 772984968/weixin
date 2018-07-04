<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    protected  $fillable=['goods_id','goods_url','image'];
}
