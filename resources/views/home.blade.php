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
                <div class="user-header shadow-lg">
                    @if(!$data['user']['avatar'])
                        <img class="avatar" src="/uploads/avatars/avatar.svg">
                    @else
                        <img class="avatar" src="/uploads/avatars/{{$data['user']['avatar']}}">
                    @endif
                    <h3>{{ $data['user']['name'] }}</h3>
                    <p>{{$data['category']['title']}}</p>
                    <p class="mb-0">
                        <i class='bx bxl-whatsapp'></i>
                        <i class='bx bxl-facebook-circle'></i>
                        <i class='bx bxl-telegram'></i>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">


                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="lead-line-tab" data-bs-toggle="tab"
                               data-bs-target="#lead-info"
                               role="tab" aria-controls="lead-info" aria-selected="true">Main</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-line-tab" data-bs-toggle="tab" data-bs-target="#profile"
                               role="tab"
                               aria-controls="profile" aria-selected="false">Contacts</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="lineTabContent">
                        <div class="tab-pane fade show active px-2" id="lead-info" role="tabpanel"
                             aria-labelledby="lead-line-tab">
                            @if($data['warning']['contacts'])
                                <div class="alert alert-danger">
                                    <b>Warning:</b> First you must fill contact details
                                </div>
                            @endif
                            <div class="mb-4">
                                <form method="POST" action="{{route('save-user')}}">
                                    @csrf
                                    <h4>User Info</h4>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Change Name:</label>
                                        <input type="text" name="name" id="name" value="{{$data['user']['name']}}"
                                               class="form-control @error('name') is-invalid @enderror"
                                        >
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Change Email:</label>
                                        <input type="email" name="email" id="email" value="{{$data['user']['email']}}"
                                               class="form-control @error('email') is-invalid @enderror"
                                        >
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <input type="submit" value="Save" class="btn btn-secondary">
                                </form>
                            </div>
                            <div class="mb-4">
                                <h4>Avatar</h4>
                                <div class="mb-3">
                                    <form method="POST" action="{{ route('upload-avatar') }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <label for="avatar" class="form-label">Change Avatar:</label>
                                        <input class="form-control mb-3" type="file" id="avatar" name="avatar">
                                        @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <input type="submit" value="Upload" class="btn btn-secondary">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-line-tab">...
                        </div>
                    </div>

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
