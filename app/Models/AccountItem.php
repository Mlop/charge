<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountItem extends Model
{
    protected $table = 'account_item';
    protected $fillable = [
        'item_id', 'account_id', 'item_value'
    ];
}
