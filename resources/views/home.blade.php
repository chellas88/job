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
                    @if ($data['category'])
                        <p>{{$data['category']['title']}}</p>
                    @endif
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
                            <a class="nav-link active" id="user-line-tab" data-bs-toggle="tab"
                               data-bs-target="#user-info"
                               role="tab" aria-controls="user-info" aria-selected="true">Main</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="address-line-tab" data-bs-toggle="tab" data-bs-target="#address"
                               role="tab"
                               aria-controls="address" aria-selected="false">Address</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contacts-line-tab" data-bs-toggle="tab" data-bs-target="#contacts"
                               role="tab"
                               aria-controls="contacts" aria-selected="false">Contacts</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="lineTabContent">
                        <div class="tab-pane fade show active px-2" id="user-info" role="tabpanel"
                             aria-labelledby="user-line-tab">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{session('success')}}
                                </div>
                            @endif
                            @if(isset($data['warning']['category']))
                                <div class="alert alert-danger mb-2">
                                    <b>Warning:</b> You must set a category
                                </div>
                            @endif
                            @if(isset($data['warning']['coordinates']))
                                <div class="alert alert-danger mb-2">
                                    <b>Warning:</b> First you must fill address details
                                </div>
                            @endif
                            @if(isset($data['warning']['contacts']))
                                <div class="alert alert-danger mb-2">
                                    <b>Warning:</b> First you must fill contact details
                                </div>
                            @endif
                            <div class="mb-4">
                                <form method="POST" action="{{route('save-user')}}">
                                    @csrf
                                    <h4>Main Info</h4>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Change Name:</label>
                                        <select type="text" name="category_id" id="category"
                                                value="{{$data['user']['category']}}"
                                                class="form-control {{ isset($data['warning']['category']) ? 'is-invalid' : ''}}"
                                        >
                                            <option value="">Select a category</option>
                                            @foreach($data['categories'] as $category)
                                                <option
                                                    value="{{$category['id']}}" {{$category['id'] == $data['user']['category_id'] ? 'selected' : ''  }}>{{$category['title']}}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
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
                                        <input type="email" name="email" id="email"
                                               value="{{$data['user']['email']}}"
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
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-line-tab">
                            <form method="POST" action="/saveAddress">
                                @csrf
                                <div class="mb-3">
                                    <label for="country">Country</label>
                                    <select id="country" name="country_id" class="form-control" required>
                                        <option value="">Select country</option>
                                        @foreach($data['countries'] as $country)
                                            <option
                                                value="{{$country['id']}}" {{ $country['id'] == $data['user']['country_id'] ? 'selected' : '' }}>{{$country['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="state">State</label>
                                    <input type="text" id="state" name="state" class="form-control"
                                           placeholder="Input your state"
                                           value="{{ $data['user']['state'] }}"
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city"
                                           class="form-control @error('city') is-invalid @enderror"
                                           placeholder="Input your city"
                                           value="{{ $data['user']['city'] }}"
                                    >
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" class="form-control"
                                           placeholder="Input your address"
                                           value="{{$data['user']['address']}}">
                                </div>
                                <div class="mb-3">
                                    <input type="submit" value="Save" class="btn btn-secondary">
                                </div>

                            </form>
                        </div>
                        <div class="tab-pane fade" id="contacts" role="tabpanel"
                             aria-labelledby="contacts-line-tab">
                            Contacts
                        </div>

                    </div>

                </div>


            </div>
        </div>
    </div>
@endsection

@if ($data['coordinates'])
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
@endif
