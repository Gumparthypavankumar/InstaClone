<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded =[];

    public function profileImage()
    {
        $imagePath=  ($this->image) ? $this->image : 'profile/1uBDVwFIaZwLYgNAvo500b8y76tJj3ityFiJ4bF6.png' ;
        return 'storage/' .$imagePath;
    }
    public function user()
    {
        // creating a one to one relationship for user and a profile userr must have a single profile
        return $this->belongsTo(User::class);
    }
    public function followers()
    {
        return $this->belongsToMany(User::class);
    }
}
