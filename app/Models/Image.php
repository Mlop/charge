<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //图片类型， 1. account 账目拍照图片
    const TYPE_ACCOUNT = 'account';
    protected $table = 'image';
    protected $fillable = [
        'path', 'type', 'rel_id'
    ];
}
