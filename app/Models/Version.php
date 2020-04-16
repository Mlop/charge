<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $table = 'version';
    protected $fillable = [
        'version', 'download_uri',
    ];
}
