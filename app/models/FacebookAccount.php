<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class FacebookAccount extends Model
{
    /**
     * Get the user that owns the facebook-account.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
