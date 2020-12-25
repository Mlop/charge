<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskTodo extends Model
{
    const STATUS_TODO = 'todo';
    const STATUS_DONE = 'done';
    const STATUS_DELAY = 'delay';
    const STATUS_UNDO = 'undo';
    protected $table = 'task_todo';
    protected $fillable = [
        'desc', 'status', 'user_id',
    ];
}
