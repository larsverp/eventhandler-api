<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $fillable = ['title', 'description', 'date', 'thumbnail', 'seats', 'postal_code', 'hnum', 'notification'];
}
