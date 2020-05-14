<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Support\Str;

class Categories extends Model
{
    protected $fillable = ['name', 'thumbnail', 'description'];

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
