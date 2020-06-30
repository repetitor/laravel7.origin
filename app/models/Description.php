<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
//    public function user()
//    {
//        return $this->belongsTo('App\User');
//    }
//
//    public function post()
//    {
//        return $this->belongsTo('App\models\Post');
//    }

    /**
     * Get the owning desciptionable model.
     */
    public function descriptionable()
    {
        return $this->morphTo();
    }
}
