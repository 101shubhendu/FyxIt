@extends('layouts.app')
<?php $titleTag = htmlspecialchars($post->title); ?>
@section('title', "| $titleTag")

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
				{{ $user->name }},
			@endforeach likes this !
			<hr>
			<p>Posted In: {{ $post->category->name }}</p>
		</div>
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
						{{ $user->name }},
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

	var loc = {lat: 28.70, lng: 77.10};
	var map = new google.maps.Map(document.getElementById('map-canvas'), {
	zoom: 15,
	center: loc
	});
	var marker = new google.maps.Marker({
	position: loc,
	map: map,
	draggable: true
	});

	var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));
	google.maps.event.addListener(searchBox, 'places_changed', function () {
	var places = searchBox.getPlaces();
	var bounds = new google.maps.LatLngBounds();
	var i, place;
	for (i = 0; place = places[i]; i++) {
	bounds.extend(place.geometry.location);
	marker.setPosition(place.geometry.location);
	}
	map.fitBounds(bounds);
	map.setZoom(15);
	});
	google.maps.event.addListener(marker, 'position_changed', function () {
	var lat = marker.getPosition().lat();
	var lng = marker.getPosition().lng();
	$('#lat').val(lat);
	$('#lng').val(lng);
	});
	}
	</script>
@endsection
