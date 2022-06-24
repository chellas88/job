@extends('layouts.app')
@section('head')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxEmjg-EGbt0m8Dr_cCWgO7IvcqA89fEU&callback=initMap"
            async defer></script>
@endsection
@section('content')
    <div class="container-fluid p-0 mb-3">
        <div class="row">
            <div class="col position-relative">
                <div id="map"></div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="profile-card shadow-lg">
                    <h4>{{$data['user']['name']}}</h4>
                    <p><span>{{$data['category']['title']}}</span></p>
                    <p>{{$data['user']['email']}}</p>
                </div>


            </div>
        </div>
    </div>
@endsection

<script>
    let center_lat = {{$data['coordinates']['lat']}};
    let center_lng = {{$data['coordinates']['lng']}};


    function initMap() {
        // The location of Uluru
        const center = {lat: center_lat, lng: center_lng};
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            center: center,
            fullscreenControl: false,
            mapTypeControl: false,
            streetViewControl: false

        });
        // The marker, positioned at Uluru
        let marker = new google.maps.Marker({
            position: {lat: center_lat, lng: center_lng},
            map: map,
        });

    }

    window.initMap = initMap;
</script>
