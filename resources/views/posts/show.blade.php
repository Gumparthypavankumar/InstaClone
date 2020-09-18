@extends('layouts.app');

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
                <img src="/storage/{{$post->image}}" alt="" class="w-100" style="max-height:400px;"/>
        </div>
        <div class="col-4">
            <div>
                <div class="d-flex align-items-center">
                    <div>
                        <img src="{{ $post->user->profile->profileImage() }}" alt="" class="rounded-circle w-100" style="max-width:40px;"/>
                    </div>
                    <div class="pl-3">
                        <div class="font-weight-bold">
                            <a href="/profile/{{$post->user->id}}">
                                <span class="text-dark">{{$post->user->username}}</span>
                            </a> | 
                            <a href="#" class="pl-3">Follow</a>
                        </div>
                    </div>
                </div>

                <hr>

                <p class="pb-3">
                    <span class="font-weight-bold">
                        <a href="/profile/{{$post->user->id}}">
                            <span class="text-dark">{{$post->user->username}}</span>
                        </a>
                    </span> {{$post->caption}}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection