<?php

namespace App\Models;

class Channel extends Model
{
    //
    protected $table = 'channels';

    public function post()
    {
        return $this->hasMany('App\Models\Post', 'channel', 'id');
    }
}
