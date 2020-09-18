<?php

namespace App;

use App\Mail\NewUserWelcomeEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','username', 'password',
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
    // boot is called when model is getting called 
    //we can interact to the events using boot method so it is going to tell you i am creating a user and you can handle that event and create a profile model too

    //there are many more events refer linkhttps://laravel.com/docs/5.1/eloquent#basic-usage
    //there are many more events refer link https://laravel.com/docs/5.1/eloquent#basic-usage
    public static function boot()
    {
        parent::boot();

        static::created(function($user)
        {
            $user->profile()->create([
                'title' => $user->username,
            ]);

            Mail::to($user->email)->send(new NewUserWelcomeEmail());
        });
    }

    // creating a one to one relationship for user and a profile userr must have a single profile

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    //creating a Many to one relationship for user and a posts user can have a many posts

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at','DESC');
    }

    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }
}
