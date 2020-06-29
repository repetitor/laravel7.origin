<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    /**
     * Get the post that owns the comments.
     */
    public function post()
    {
        return $this->belongsTo('App\models\Post');
    }
}
