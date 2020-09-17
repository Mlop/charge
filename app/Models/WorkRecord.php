<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkRecord extends Model
{
    protected $table = 'work_record';
    protected $fillable = [
        'work_date', 'record_info', 'user_id',
    ];
}
