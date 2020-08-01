<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $timestamps = false;

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
