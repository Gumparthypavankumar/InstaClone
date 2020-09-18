<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    // public function __construct()
    // {
    //     return $this->middleware(Auth::class);
    // }
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
        //dd($user);//dd stands for die and dump after letting this it will stop execution this is generraly used in development
        $postCount = Cache::remember('count.posts.' . $user->id ,
        now()->addSeconds(30),
        function() use($user){
            return $user->posts->count();
        });
        $followerscount = Cache::remember('count.followers.' . $user->id ,
        now()->addSeconds(30),
        function() use($user){
            return  $user->profile->followers->count();
        });
        $followingcount = Cache::remember('count.following.' . $user->id ,
        now()->addSeconds(30),
        function() use($user){
            return $user->following->count();
        });
        return view('profiles.index',compact('user','follows','postCount','followerscount','followingcount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update',$user->profile);
        return view('profiles.edit',compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update',$user->profile);
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => ''
        ]);
        if(request('image'))
        {
            $imagePath = request('image')->store('profile','public');
            $image = Image::make(public_path("/storage/{$imagePath}"))->fit(1000,1000);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }
        // ?? represents or if the request does not have an image then make the image field empty in migration
        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        return redirect('profile/'.auth()->user()->id);
    }
}
