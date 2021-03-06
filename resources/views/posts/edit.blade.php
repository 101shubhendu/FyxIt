@extends('layouts.app')

@section('title', '| Edit Post')

@section('stylesheets')
	<style>
		#map-canvas{
			width: 350px;
			height: 250px;
		}
	</style>
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
		{!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'PUT','files'=> true]) !!}
		<div class="col-md-8 col-md-offset-1">
			{{ Form::label('title', 'Title:') }}
			{{ Form::text('title', null, ["class" => 'form-control input-lg']) }}

			{{ Form::label('slug', 'Slug:', ['class' => 'form-spacing-top']) }}
			{{ Form::text('slug', null, ['class' => 'form-control']) }}

			{{ Form::label('category_id', "Category:", ['class' => 'form-spacing-top']) }}
			{{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}

			{{ Form::label('tags', 'Tags:', ['class' => 'form-spacing-top']) }}
			{{ Form::select('tags[]', $tags, null, ['class' => 'form-control select2-multi', 'multiple' => 'multiple']) }}

			{{ Form::label('body', "Body:", ['class' => 'form-spacing-top']) }}
			{{ Form::textarea('body', null, ['class' => 'form-control']) }}
			{{ Form::label('featured_img', 'Upload a Featured Image') }}
			{{ Form::file('featured_img') }}
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
		</div>

		<div class="col-md-3">
			<div class="well">
				<dl class="dl-horizontal">
					<dt>Created At:</dt>
					<dd>{{ date('M j, Y h:ia', strtotime($post->created_at)) }}</dd>
				</dl>

				<dl class="dl-horizontal">
					<dt>Last Updated:</dt>
					<dd>{{ date('M j, Y h:ia', strtotime($post->updated_at)) }}</dd>
				</dl>
				<hr>
				<div class="row">
					<div class="col-sm-6">
						{!! Html::linkRoute('posts.show', 'Cancel', array($post->id), array('class' => 'btn btn-danger btn-block')) !!}
					</div>
					<div class="col-sm-6">
						{{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) }}
					</div>
				</div>

			</div>
		</div>
		{!! Form::close() !!}
	</div>	<!-- end of .row (form) -->

@stop

@section('scripts')
	<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCno458WmFmeRpV7ON1EqcHcZkbBbCBEyU&libraries=places&callback=initialize" type="text/javascript">
	</script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	{!! Html::script('js/select2.min.js') !!}

	<script type="text/javascript">

		$('.select2-multi').select2();
		$('.select2-multi').select2().val({!! json_encode($post->tags()->allRelatedIds()) !!}).trigger('change');

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