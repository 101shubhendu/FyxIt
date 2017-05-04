@extends('layouts.app')
<?php $titleTag = htmlspecialchars($post->title); ?>
@section('title', "| $titleTag")
@section('stylesheets')
    <style>
        #map-canvas{
            width: 350px;
            height: 250px;
        }
    </style>
    @endsection
@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<img src="{{asset('/images/' . $post->image)}}" width="800" height="400" />
			<h1>{{ $post->title }}</h1>
			<p>{!! $post->body !!}</p>
			@if ($post->isLiked)
				<a href="{{ route('post.like', $post->id) }}">Unlike</a>
			@else
				<a href="{{ route('post.like', $post->id) }}">Like</a>
			@endif
			@foreach ($post->likes as $user)
                <a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a>
                ,
			@endforeach likes this !
			<hr>
			<p>Posted In: {{ $post->category->name }}</p>
		</div>
	</div>
    <div class="col-md-8 col-md-offset-2">
        <h3>{{  "Location:" }}</h3>
        <h3>{{ $location->area }}</h3>
        <div id="map-canvas"></div>
    </div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h3 class="comments-title"><span class="glyphicon glyphicon-comment"></span>  {{ $post->comments()->count() }} Comments</h3>
			@foreach($post->comments as $comment)
				<div class="comment">
					<div class="author-info">

						<img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?s=50&d=monsterid" }}" class="author-image">
						<div class="author-name">
							<h4>{{ $comment->name }}</h4>
							<p class="author-time">{{ date('F nS, Y - g:iA' ,strtotime($comment->created_at)) }}</p>
						</div>

					</div>

					<div class="comment-content">
						{{ $comment->comment }}
						@if ($comment->isLiked)
							<a href="{{ route('comment.like', $comment->id) }}">Unlike</a>
						@else
							<a href="{{ route('comment.like', $comment->id) }}">Like</a>
						@endif
					</div>
					@foreach ($comment->likes as $user)
                        <a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a>
					@endforeach likes this !

				</div>
			@endforeach
		</div>
	</div>

	<div class="row">
		<div id="comment-form" class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
			{{ Form::open(['route' => ['comments.store', $post->id], 'method' => 'POST']) }}

				<div class="row">
					<div class="col-md-6">
						{{ Form::label('name', "Name:") }}
						{{ Form::text('name', null, ['class' => 'form-control']) }}
					</div>

					<div class="col-md-6">
						{{ Form::label('email', 'Email:') }}
						{{ Form::text('email', null, ['class' => 'form-control']) }}
					</div>

					<div class="col-md-12">
						{{ Form::label('comment', "Comment:") }}
						{{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}

						{{ Form::submit('Add Comment', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top:15px;']) }}
					</div>
				</div>

			{{ Form::close() }}
		</div>
	</div>
@endsection

@section('scripts')
	<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCno458WmFmeRpV7ON1EqcHcZkbBbCBEyU&libraries=places&callback=initialize" type="text/javascript">
	</script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>

	function initialize() {

        var lat = {{ $location->lat }};
        var lng = {{ $location->lng }};

        var map = new google.maps.Map(document.getElementById('map-canvas'), {
            zoom: 15,
            center:{
                lat: lat,
                lng: lng
            }
        });
        var marker = new google.maps.Marker({
            position: {
                lat: lat,
                lng: lng
            },
            map: map,
        });
	}
	</script>
@endsection
