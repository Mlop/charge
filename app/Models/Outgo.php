<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outgo extends Model
{
    protected $table = 'outgo';
    protected $fillable = [
        'remark', 'user_id', 'book_id', 'cash', 'category_id', 'record_at'
    ];
}
