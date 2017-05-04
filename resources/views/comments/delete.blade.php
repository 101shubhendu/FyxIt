@extends('layouts.app')

@section('title', '| DELETE COMMENT?')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			@if(\Illuminate\Support\Facades\Auth::id() == $comment->user_id)

			<h1>DELETE THIS COMMENT?</h1>
			<p>
				<strong>Name:</strong> {{ $comment->name }}<br>
				<strong>Email:</strong> {{ $comment->email }}<br>
				<strong>Comment:</strong> {{ $comment->comment }}
			</p>

			{{ Form::open(['route' => ['comments.destroy', $comment->id], 'method' => 'DELETE']) }}
				{{ Form::submit('YES DELETE THIS COMMENT', ['class' => 'btn btn-lg btn-block btn-danger']) }}
			{{ Form::close() }}
				@else
			<h3>Not allowed</h3>
				@endif
		</div>
	</div>

@endsection