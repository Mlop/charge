<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'loan';
    protected $fillable = [
        'remark', 'user_id', 'book_id', 'cash', 'category_id', 'record_at'
    ];
}
