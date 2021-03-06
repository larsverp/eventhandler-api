<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Support\Str;

class Events extends Model
{
    protected $fillable = ['title', 'description', 'host_id', 'begin_date', 'end_date', 'thumbnail', 'seats', 'postal_code', 'hnum', 'street', 'city', 'notification', 'rockstar'];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
