<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * Get all of the users that are assigned this tag.
     */
    public function users()
    {
//        return $this->belongsToMany('App\User');
        return $this->morphedByMany('App\User', 'taggable');
    }

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function posts()
    {
        return $this->morphedByMany('App\models\Post', 'taggable');
    }


}
