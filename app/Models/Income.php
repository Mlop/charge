<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'income';
    protected $fillable = [
        'remark', 'user_id', 'book_id', 'cash', 'category_id',
    ];
}
