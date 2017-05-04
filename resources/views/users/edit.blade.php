@extends('layouts.app')
@section('title', "Edit Profile")

@section('content')

    <div class="row">
        {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'PUT','files' =>true]) !!}
        <div class="col-md-8 col-md-offset-1">
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name', $user->name, ["class" => 'form-control input-lg']) }}

            {{ Form::label('email', 'Email:', ['class' => 'form-spacing-top']) }}
            {{ Form::text('email', $user->email, ['class' => 'form-control']) }}

            {{ Form::label('address', "Address:", ['class' => 'form-spacing-top']) }}
            {{ Form::text('address', $user->address, ['class' => 'form-control']) }}

            {{ Form::label('image', 'Upload your Image') }}
            {{ Form::file('image') }}
            <div class="col-sm-6">
                {{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) }}
            </div>

@endsection