<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    const TYPE_OUTGO = 'outgo';
    const TYPE_INCOME = 'income';
    const TYPE_LOAN = 'loan';
    protected $table = 'account';
    protected $fillable = [
        'remark', 'user_id', 'book_id', 'cash', 'category_id', 'record_at', 'type', 'items', 'contact'
    ];
    static $typeConfig = [
        'outgo'=>'支出',
        'income'=>'收入',
        'loan'=>'借贷',
    ];
}
