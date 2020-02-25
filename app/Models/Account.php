<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'account';
    protected $fillable = [
        'remark', 'user_id', 'book_id', 'cash', 'category_id', 'record_at', 'type', 'items', 'contact'
    ];
}
