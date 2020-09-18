<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded=[];// temporarily removing the guarding
   //creating a Many to one relationship for user and a posts user can have a many posts and many posts can have a single user
   public function user()
    {
        return $this->belongsTo(User::class);
    }
}
