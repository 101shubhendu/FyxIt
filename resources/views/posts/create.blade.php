@extends('layouts.app')

@section('title', '| Create New Post')

@section('stylesheets')
    <style>
        #map-canvas{
            width: 350px;
            height: 250px;
        }
    </style>
	{!! Html::style('css/parsley.css') !!}
	{!! Html::style('css/select2.min.css') !!}
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

	<script>
		tinymce.init({
			selector: 'textarea',
			plugins: 'link code',
			menubar: false
		});
	</script>

@endsection


@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Create New Post</h1>
			<hr>
			{!! Form::open(array('route' => 'posts.store', 'data-parsley-validate' => '', 'files' => true)) !!}
				{{ Form::label('title', 'Title:') }}
				{{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}

				{{ Form::label('slug', 'Slug:') }}
				{{ Form::text('slug', null, array('class' => 'form-control', 'required' => '', 'minlength' => '5', 'maxlength' => '255') ) }}

				{{ Form::label('category_id', 'Category:') }}
				<select class="form-control" name="category_id">
					@foreach($categories as $category)
						<option value='{{ $category->id }}'>{{ $category->name }}</option>
					@endforeach

				</select>


				{{ Form::label('tags', 'Tags:') }}
				<select class="form-control select2-multi" name="tags[]" multiple="multiple">
					@foreach($tags as $tag)
						<option value='{{ $tag->id }}'>{{ $tag->name }}</option>
					@endforeach

				</select>

				{{ Form::label('featured_img', 'Upload a Featured Image') }}
				{{ Form::file('featured_img') }}

				{{ Form::label('body', "Post Body:") }}
				{{ Form::textarea('body', null, array('class' => 'form-control')) }}

            <h3>Add Location</h3>
            <div class="form-group">
                <label for="">Map</label>
                <input type = "text" name ="area" id="searchmap">
                <div id="map-canvas"></div>
            </div>
            <div class="form-group">
                {{ Form::label('lat', 'Lat:') }}
                {{ Form::text('lat', null, array('class' => 'form-control input-sm')) }}
            </div>
            <div class="form-group">
                {{ Form::label('lng', 'Lng:') }}
                {{ Form::text('lng', null, array('class' => 'form-control input-sm')) }}
            </div>
            {{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top: 20px;')) }}
            {!! Form::close() !!}
		</div>
	</div>

@endsection


@section('scripts')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCno458WmFmeRpV7ON1EqcHcZkbBbCBEyU&libraries=places&callback=initialize" type="text/javascript">
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	{!! Html::script('js/parsley.min.js') !!}
	{!! Html::script('js/select2.min.js') !!}

	<script type="text/javascript">
		$('.select2-multi').select2();
	</script>
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
