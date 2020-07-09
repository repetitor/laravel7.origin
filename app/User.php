<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'subscriber_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the phone record associated with the user.
     */
    public function phone()
    {
        return $this->hasOne('App\Phone');
    }

    /**
     * Get the facebook-account record associated with the user.
     */
    public function facebookAccount()
    {
        return $this->hasOne('App\models\FacebookAccount', 'user_id', 'id');
    }

    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany('App\models\Post');
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\models\Role');
    }

    /**
     * Get the user's description.
     */
    public function description()
    {
        return $this->morphOne('App\models\Description', 'descriptionable');
    }

    /**
     * Get all of the tags for the user.
     */
    public function tags()
    {
//        return $this->belongsToMany('App\models\tags');
        return $this->morphToMany('App\models\Tag', 'taggable');
    }

    //    public static function setSubscriberId(User $user)
    public function setSubscriberId()
    {
//        $user->update(['subscriber_id' => 100000 + $user->id]);
        $this->update(['subscriber_id' => 100000 + $this->id]);
    }
}
