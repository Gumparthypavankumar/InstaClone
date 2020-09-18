@extends('layouts.app')

@section('content')

    @if($user->following()->count() == 0 )
    <div class="container">
        <div class="row">
            <div class="col-12" >
                    <div class="card bg-info text-white text-center">
                        <div class="card-body">
                            You have No followers Yet Follow someone to See their Posts
                        </div>
                    </div>
                    <div class="col-6 offset-3 pt-4"><img src="{{asset('./images/nature.jpg')}}" class="w-100" alt=""/></div>
            </div>
        </div>
    </div>
    @else
    @forelse($posts as $post)
        <div class="container">
            <div class="row">
                <div class="col-6 offset-3">
                <a href="/profile/{{$post ->user->id}}"><img src="/storage/{{$post->image}}" alt="" class="w-100" style="max-height:400px;"/></a>
                </div>
            </div>
            <div class="row pt-2 pb-4">
                    <div class="col-6  offset-3">
                            <div>
                                <p>
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
                
        </div>
    {{-- //use forelse instyead of if else  @forelse ... @empty ... @endforelse --}}
    @empty
    <div class="container">
        <div class="row">
            <div class="col-12" >
                    <div class="card bg-info text-white text-center">
                        <div class="card-body">
                            You have No followers Yet Follow someone to See their Posts
                        </div>
                    </div>
            </div>
        </div>
    </div>
    @endforelse
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{$posts->links()}}
        </div>
    </div>
    @endif
@endsection
