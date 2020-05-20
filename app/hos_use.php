<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hos_use extends Model
{
    protected $fillable = ['host_id', 'user_id', 'points', 'following'];

    public $timestamps = false;

    protected $hidden = [
        'id',
    ];
}
