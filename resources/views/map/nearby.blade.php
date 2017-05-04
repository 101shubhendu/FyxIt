@extends('layouts.app')

@section('title', '| Search')

@section('content')

    <div class="col-md-8 col-md-offset-2">
        {!! Form::open(['method'=>'GET','url'=>'map/posts','class'=>'navbar-form navbar-left','role'=>'search'])  !!}

        <div class="input-group custom-search-form">
            <input type="text" class="form-control" name="search" placeholder="Search...">
            {{ Form::submit('Search', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top:15px;']) }}
            {!! Form::close() !!}
        </div>
    </div>
    @if($locations)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Posts</h1>
        </div>
    </div>

    @foreach ($locations as $location)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>{{ $location['post']['title'] }}</h2>
                <h5>Published: {{ date('M j, Y', strtotime($location['post']['created_at'])) }}</h5>

                <p>{{ substr(strip_tags($location['post']['body']), 0, 250) }}{{ strlen(strip_tags($location['post']['body'])) > 250 ? '...' : "" }}</p>

                <a href="{{ route('feed.single', $location['post']['slug']) }}" class="btn btn-primary">Read More</a>
                <hr>
            </div>
        </div>
    @endforeach

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                {{--{!! $location['posts']->links(); !!}--}}
            </div>
        </div>
    </div>
@endif

@endsection