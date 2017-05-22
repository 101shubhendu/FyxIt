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
        {!! Form::open(['method'=>'POST','url'=>'/map','class'=>'navbar-form navbar-left'])  !!}

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
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCno458WmFmeRpV7ON1EqcHcZkbBbCBEyU&libraries=visualization&callback=initialize" type="text/javascript">
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>

        function initialize() {
            {{--var locations = [--}}
                    {{--@foreach($locations as $location)--}}
                {{--[{{$location->lat}}, {{$location->lng}}],--}}
                {{--@endforeach--}}
            {{--];--}}
            {{--map = new google.maps.Map(document.getElementById('map-canvas'), {--}}
                {{--zoom: 10,--}}
                {{--center: new google.maps.LatLng(locations[0][0], locations[0][1]),--}}
                {{--mapTypeId: 'roadmap'--}}
            {{--});--}}


            {{--for (i = 0; i < locations.length; i++) {--}}
                {{--var location = new google.maps.LatLng(locations[i][0], locations[i][1]);--}}
{{--//--}}
{{--//                var marker = new google.maps.Marker({--}}
{{--//                    position: location--}}
{{--//                });--}}
{{--//                marker.setMap(map);--}}
                {{--var heatmap = new google.maps.visualization.HeatmapLayer({--}}
                    {{--location: location,--}}
                {{--});--}}
                {{--heatmap.setMap(map);--}}

            {{--}--}}

            var heatMapData = [
                {location: new google.maps.LatLng(37.782, -122.447), weight: 0.5},
                new google.maps.LatLng(37.782, -122.445),
                {location: new google.maps.LatLng(37.782, -122.443), weight: 2},
                {location: new google.maps.LatLng(37.782, -122.441), weight: 3},
                {location: new google.maps.LatLng(37.782, -122.439), weight: 2},
                new google.maps.LatLng(37.782, -122.437),
                {location: new google.maps.LatLng(37.782, -122.435), weight: 0.5},

                {location: new google.maps.LatLng(37.785, -122.447), weight: 3},
                {location: new google.maps.LatLng(37.785, -122.445), weight: 2},
                new google.maps.LatLng(37.785, -122.443),
                {location: new google.maps.LatLng(37.785, -122.441), weight: 0.5},
                new google.maps.LatLng(37.785, -122.439),
                {location: new google.maps.LatLng(37.785, -122.437), weight: 2},
                {location: new google.maps.LatLng(37.785, -122.435), weight: 3}
            ];

            var sanFrancisco = new google.maps.LatLng(37.774546, -122.433523);

            map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: sanFrancisco,
                zoom: 13,
                mapTypeId: 'satellite'
            });

            var heatmap = new google.maps.visualization.HeatmapLayer({
                data: heatMapData
            });
            heatmap.setMap(map);
        }
    </script>
@endsection

