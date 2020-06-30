<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * Get the comments for the blog post.
     */
    public function comments()
    {
        return $this->hasMany('App\models\Comment');
    }

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the post's description.
     */
    public function description()
    {
        return $this->morphOne('App\models\Description', 'descriptionable');
    }

    /**
     * Get all of the tags for the post.
     */
    public function tags()
    {
//        return $this->belongsToMany('App\models\tags');
        return $this->morphToMany('App\models\Tag', 'taggable');
    }
}
