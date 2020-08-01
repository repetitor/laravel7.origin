<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
