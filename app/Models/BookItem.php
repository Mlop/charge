<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookItem extends Model
{
    protected $table = 'book_item';
    protected $fillable = [
        'item_id', 'user_id', 'book_id'
    ];
}
