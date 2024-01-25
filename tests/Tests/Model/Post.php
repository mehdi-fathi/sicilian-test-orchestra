<?php
namespace Tests\Tests\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // ...

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ...
}