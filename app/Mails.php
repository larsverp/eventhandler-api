<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Support\Str;

class Mails extends Model
{
    protected $fillable = ['title', 'language', 'subject', 'body'];

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
