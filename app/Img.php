<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Img extends Model
{
    use SoftDeletes;
    
    protected $table = 'images';
    
    public function imageable()
    {
        return $this->morphTo();
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function compartirs()
    {
        return $this->morphMany(Compartir::class, 'compartirable');
    }
}
