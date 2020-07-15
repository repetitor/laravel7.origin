<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
//    /**
//     * The attributes that aren't mass assignable.
//     *
//     * @var array
//     */
//    protected $guarded = [];

    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
