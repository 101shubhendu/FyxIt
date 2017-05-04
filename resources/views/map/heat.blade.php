@extends('layouts.app')
@section('title', "Heat Map")
@section('stylesheets')
    <style>
        #map-canvas{
            width: 700px;
            height: 700px;
        }
    </style>
@endsection
@section('content')
    <div class="col-md-8 col-md-offset-2">
        {!! Form::open(['method'=>'POST','url'=>'/map','class'=>'navbar-form navbar-left','role'=>'search'])  !!}

        <div class="input-group custom-search-form">
            <input type="text" class="form-control" name="search" placeholder="Search...">
            {{ Form::submit('Search', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top:15px;']) }}

        </div>
    </div>
        {!! Form::close() !!}
    <div class="col-md-8 col-md-offset-2">
    <div id="map-canvas"></div>
    </div>


@endsection
@section('scripts')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCno458WmFmeRpV7ON1EqcHcZkbBbCBEyU&libraries=places&callback=initialize" type="text/javascript">
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>

        function initialize() {
            var locations = [
                    @foreach($locations as $location)
                [{{$location->lat}}, {{$location->lng}}],
                @endforeach
            ];
            map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 10,
                center: new google.maps.LatLng(locations[0][0], locations[0][1]),
                mapTypeId: 'roadmap'
            });


            for (i = 0; i < locations.length; i++) {
                var location = new google.maps.LatLng(locations[i][0], locations[i][1]);

                var marker = new google.maps.Marker({
                    position: location
                });
                marker.setMap(map);

            }
        }
    </script>
@endsection

