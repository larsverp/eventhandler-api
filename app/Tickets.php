<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $fillable = ['event_id', 'user_id', 'token', 'scanned'];

    protected $hidden = [
        'id',
    ];
}
