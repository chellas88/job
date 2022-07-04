@extends('layouts.app')
@section('head')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxEmjg-EGbt0m8Dr_cCWgO7IvcqA89fEU&callback=initMap"
            async defer></script>
@endsection

@section('content')
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col">
                <div id="map"></div>
            </div>
        </div>
    </div>
    <div class="container my-3">
        <div class="row">
            <div class="col-sm-3">
                <div class="search-card">
                    <form id="search-form" method="GET" action="/search">
                        @csrf
                        <div class="search-card-header">
                            Search
                        </div>
                        <div class="search-card-body">
                            <div class="mb-2">
                                <label for="category">Category</label>
                                <select name="category_id" id="category" class="form-control">
                                    <option value="">All categories</option>
                                    @foreach($data['categories'] as $category)
                                        <option
                                            value="{{$category['id']}}" {{ $data['current_category'] == $category['id'] ? 'selected' : '' }}>
                                            {{$category['title_'.\Illuminate\Support\Facades\App::currentLocale()]}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="country">Country</label>
                                <select name="country_id" id="country" class="form-control">
                                    @foreach($data['countries'] as $country)
                                        <option
                                            value="{{$country['id']}}" {{ $data['current_country'] == $country['id'] ? 'selected' : '' }}>
                                            {{$country['title_'.\Illuminate\Support\Facades\App::currentLocale()]}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="city">City</label>
                                <input type="text" name="city" id="city" class="form-control"
                                       value="{{$data['location']}}">
                            </div>
                            <div class="mb-2">
                                <label for="lang">Language</label>
                                <select name="lang" id="lang" class="form-control">
                                    <option>Select Language</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <input type="submit" value="Search" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-9">
                @if ($data['list']->isEmpty())
                    <div class="card p-4">
                        Nothing not found
                    </div>
                @else
                    @foreach($data['list'] as $item)
                        <div class="card user-card mb-3">
                            <div class="card-body">
                                <div class="user-card-mini justify-content-between">
                                    <div class="avatar">
                                        @if(!$item['avatar'])
                                            <img class="avatar" src="/uploads/avatars/avatar.svg">
                                        @else
                                            <img class="avatar" src="/uploads/avatars/{{$item['avatar']}}">
                                        @endif
                                    </div>
                                    <div class="user-info w-100">
                                        <p><b>{{$item['name']}}</b></p>
                                        <p>{{$item['category']['title_'.\Illuminate\Support\Facades\App::currentLocale()]}}</p>
                                        @if ($item->getRating() > 0 && $item->getRating() < 2)
                                            <x-rating.stars_05/>
                                        @elseif ($item->getRating() == 1)
                                            <x-rating.stars_1/>
                                        @elseif ($item->getRating() > 1 && $item->getRating() < 2)
                                            <x-rating.stars_15/>
                                        @elseif ($item->getRating() == 2)
                                            <x-rating.stars_2/>
                                        @elseif ($item->getRating() > 2 && $item->getRating() < 3)
                                            <x-rating.stars_25/>
                                        @elseif ($item->getRating() == 3)
                                            <x-rating.stars_3/>
                                        @elseif ($item->getRating() > 3 && $item->getRating() < 4)
                                            <x-rating.stars_35/>
                                        @elseif ($item->getRating() == 4)
                                            <x-rating.stars_4/>
                                        @elseif ($item->getRating() > 4 && $item->getRating() < 5)
                                            <x-rating.stars_45/>
                                        @elseif ($item->getRating() == 5)
                                            <x-rating.stars_5/>
                                        @endif
                                    </div>
                                    <div class="open-profile">
                                        <a href="/profile/{{$item['id']}}" class="btn btn-secondary">Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{--                @endif--}}
                    {{ $data['list']->appends(request()->query())->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection

<script>
    let center_lat = {{$data['myLocation']['lat']}};
    let center_lng = {{$data['myLocation']['lng']}};
    let users = @json($data['users']);
    let country;

    function initMap() {
        // The location of Uluru
        const center = {lat: center_lat, lng: center_lng};
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            center: center,
            fullscreenControl: true,
            mapTypeControl: false,
            streetViewControl: false

        });

        map.addListener('bounds_changed', () => {
            var bounds = map.getBounds();
            let max_lat = bounds.ub.hi
            let min_lat = bounds.ub.lo
            let max_lng = bounds.Ra.hi
            let min_lng = bounds.Ra.lo
            users.forEach(user => {
                lat = +user.geo.lat
                lng = +user.geo.lng
                if (lat > min_lat && lat < max_lat && lng > min_lng && lng < max_lng){
                    let marker = new google.maps.Marker({
                    position: {lat: +user.geo.lat, lng: +user.geo.lng},
                    map: map,
                    title: user.name
                     });
                    let info = new google.maps.InfoWindow({
                    content: `<b>${user.name}</b>
                    <p>${user.contacts}</p>
                    `
                    })
                    marker.addListener('click', () => {
                    info.open(map, marker)
                    })
                }
            })
        })
    }


</script>



