<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function images()
    {
        return $this->morphMany(Img::class, 'imageable');
    }
    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }
    public function comentarios()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
    
    public function compartirs()
    {
        return $this->morphMany(Compartir::class,'compartirable');
    }
}
