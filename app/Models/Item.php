<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    const VALUE_TYPE_STRING = 0;
    const VALUE_TYPE_DECIMAL = 1;
    const VALUE_TYPE_INT = 2;
    const VALUE_TYPE_COMBOX = 3;
    protected $table = 'item';
    protected $fillable = [
        'title', 'value_type', 'data_from'
    ];
    public $valueTypes = ['string', 'decimal', 'int', 'combox'];
}
