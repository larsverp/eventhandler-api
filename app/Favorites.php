<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorites extends Model
{
    protected $fillable = ['event_id', 'user_id'];

    public $timestamps = false;

    protected $hidden = [
        'id',
    ];
}
