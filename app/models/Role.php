<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMIN = 1;
    const GUEST = 2;

    const TYPES = [
        self::ADMIN => 'Admin',
        self::GUEST => 'Guest',
    ];

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
