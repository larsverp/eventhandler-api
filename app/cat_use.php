<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cat_use extends Model
{
    protected $fillable = ['category_id', 'user_id', 'points', 'following'];

    public $timestamps = false;

    protected $hidden = [
        'id',
    ];
}
