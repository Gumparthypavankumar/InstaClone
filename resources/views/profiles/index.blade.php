@extends('layouts.app')

@section('content')
<div class="container ">
   <div class="row">
       <div class="col-3 p-5">
            <img src="/{{$user->profile->profileImage()}}" alt="" class="rounded-circle w-100"/>
       </div>
       <div class="col-9 p-5">
            <div class="d-flex align-items-baseline justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="h4">{{$user->username}}</div>
                    <follows-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follows-button>
                </div>
                @can('update',$user->profile)
                    <a href="/p/create">Add New Post</a>
                @endcan
            </div>
            <div class="pb-3">
                @can('update',$user->profile)
                    <a href="/profile/{{$user->id}}/edit">Edit Profile</a>
                @endcan
            </div>
            <div class="d-flex">
                <div class="pr-3"><strong class="pr-1">{{ $postCount }}</strong>Posts</div>
            <div class="pr-3"><strong class="pr-1">{{ $followerscount }}</strong>followers</div>
            <div class="pr-3"><strong class="pr-1">{{ $followingcount }}</strong>following</div>
            </div>
            <div class="pt-1">
            <div class="pt-2"><strong>{{$user->profile->title}}</strong></div>
            <div class="pt-2">{{$user->profile->description}}</div>
            <div class="pt-2"><a href="{{$user->profile->url}}">{{$user->profile->url}}</a></div>  
            {{-- you can use ?? which indicates or which can be used when you want some default value if it is not set. --}}
            </div>
       </div>
   </div>
   <div class="row">
       @foreach($user->Posts as $post)
        <div class="col-4 pb-4">
            <a href="/p/{{$post->id}}">
                <img src="/storage/{{$post->image}}" class="w-100" alt="Sorry!"/>
            </a>
        </div>
       @endforeach
   </div>
</div>
@endsection
