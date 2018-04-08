<?php

namespace App\Models;

class Tag extends Model
{
    //
    protected $table = 'tags';

    public function post()
    {
        return $this->belongsToMany('App\Models\Post', 'post_tag');
    }

    public function postId()
    {
        return $this->hasMany('App\Models\PostTag', 'tag_id', 'id');
    }
}
