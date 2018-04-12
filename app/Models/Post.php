<?php

namespace App\Models;

class Post extends Model
{
    //
    protected $table = 'posts';

    public function tag()
    {
        return $this->belongsToMany('App\Models\Tag', 'post_tag', 'post_id', 'tag_id');
    }

    public function channel()
    {
        return $this->hasOne('App\Models\Channel', 'id', 'channel');
    }

    public function postTag()
    {
        return $this->hasMany('App\Models\PostTag', 'post_id', 'id');
    }
}
