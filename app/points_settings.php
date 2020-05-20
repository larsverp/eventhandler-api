<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class points_settings extends Model
{
    protected $fillable = ['setting', 'value'];

    public $timestamps = false;

    protected $hidden = [
        'id',
    ];
}
