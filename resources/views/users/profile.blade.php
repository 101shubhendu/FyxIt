@extends('layouts.app')
@section('title', "Profile")

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <img src="{{asset('/images/' . $user->image)}}" width="800" height="400" />
            <h1>{{ $user->name }}</h1>
            <p>{!! $user->email !!}</p>
            <hr>
            <p>Located In: {{ $user->address }}</p>
        </div>
    @if(Auth::id() == $user->id)
    <div class="col-md-2">
        <a href="{{ route('user.edit',$user->id) }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Edit</a>
    </div>
    @endif
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Timeline</h1>
        </div>
    </div>
    @foreach ($posts as $post)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>{{ $post->title }}</h2>
                <h5>Published: {{ date('M j, Y', strtotime($post->created_at)) }}</h5>

                <p>{{ substr(strip_tags($post->body), 0, 250) }}{{ strlen(strip_tags($post->body)) > 250 ? '...' : "" }}</p>

                <a href="{{ route('feed.single', $post->slug) }}" class="btn btn-primary">Read More</a>
                <hr>
            </div>
        </div>
    @endforeach

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                {{--{!! $posts->links(); !!}--}}
            </div>
        </div>
    </div>
@endsection

