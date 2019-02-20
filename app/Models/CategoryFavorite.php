<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryFavorite extends Model
{
    protected $table = 'category_favorite';
    protected $fillable = [
        'user_id', 'category_id'
    ];
}
