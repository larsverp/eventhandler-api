<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Support\Str;

class Hosts extends Model
{
    protected $fillable = ['first_name', 'insertion', 'last_name', 'description', 'picture'];
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
