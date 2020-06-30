<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    /**
     * Get the owning desciptionable model.
     */
    public function descriptionable()
    {
        return $this->morphTo();
    }
}
