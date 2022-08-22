@extends('layouts.app')
@section('head')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxEmjg-EGbt0m8Dr_cCWgO7IvcqA89fEU&callback=initMap"
            async defer></script>
@endsection

@section('content')
    <div class="container-fluid p-0 main-block">
        <div class="row">
            <div class="col">
                <div id="map"></div>
                <div class="search active">
                    <form id="search-form" method="GET" action="{{route('search')}}">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" value="{{ $data['current_category'] }}" name="category_id"
                                   id="category_id">
                            <input type="hidden" value="{{ $data['current_subcategory'] }}" name="subcategory_id"
                                   id="subcategory_id">
                            <button type="button" class="btn btn-secondary form-control text-start" id="show-categories"
                                    onclick="showCategories()">
                                {{ __('main.all_category') }}
                            </button>
                            <div class="category-list">
                                <a class="dropdown-item category-item" href="#" category="{{ __('main.all_category') }}"
                                   onclick="selectCategory('', this)">
                                    {{ __('main.all_category') }}
                                </a>
                                @foreach($data['categories'] as $item_category)
                                    <a class="dropdown-item category-item" href="#"
                                       category="{{ $item_category['title_'.\Illuminate\Support\Facades\App::currentLocale()] }}"
                                       onclick="selectCategory({{ $item_category['id'] }}, this)">
                                        {{ $item_category['title_'.\Illuminate\Support\Facades\App::currentLocale()] }}
                                    </a>
                                    <div class="subcategory-list" id="subcategories_{{ $item_category['id'] }}">
                                        <a class="" onclick="selectSubcategory('', this)"
                                           category="{{ $item_category['title_'.\Illuminate\Support\Facades\App::currentLocale()] }}">
                                            {{ __('main.all_category') }}
                                        </a>
                                        @foreach($data['subcategories'] as $item_subcategory)
                                            @if($item_subcategory['category_id'] == $item_category['id'])
                                                <a class=""
                                                   onclick="selectSubcategory({{ $item_subcategory['id'] }}, this)"
                                                   subcategory="{{ $item_subcategory['title_'.\Illuminate\Support\Facades\App::currentLocale()] }}">
                                                    {{ $item_subcategory['title_'.\Illuminate\Support\Facades\App::currentLocale()] }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="text" class="form-control"
                                   placeholder="{{ __('main.input_location') }}" id="location"
                                   name="location" value="{{ $data['location'] }}">
                            <i class='bx bx-current-location location-icon' onclick="checkPosition()"></i>
                        </div>
                        <div class="mb-3">
                            {{--                    <label for="lang">Language</label>--}}
                            <select type="text" class="form-control" id="lang" name="lang" onchange="changeLang()">
                                <option value="0">{{ __('main.select_language') }}</option>
                                @foreach($data['languages'] as $language)
                                    <option
                                        value="{{ $language['id'] }}" {{ $language['id'] == $data['current_language'] ? 'selected' : '' }}>
                                        {{ $language['title_' . \Illuminate\Support\Facades\App::currentLocale()] }}
                                    </option>
                                @endforeach
                            </select>
                            <i class='bx bx-current-location'></i>
                        </div>

                        <input type="submit" value="{{ __('main.search') }}" class="btn">

                    </form>
                    <div class="search-show-hide" id="showHideSearch"><i class='icon-chevron-left'></i></div>
                </div>

            </div>
        </div>
    </div>
    <div class="container my-3">
        <div class="row">
            {{--            <div class="col-sm-3">--}}
            {{--                <div class="search-card">--}}
            {{--                    <form id="search-form" method="GET" action="/search">--}}
            {{--                        @csrf--}}
            {{--                        <div class="search-card-header">--}}
            {{--                            Search--}}
            {{--                        </div>--}}
            {{--                        <div class="search-card-body">--}}
            {{--                            <div class="mb-2">--}}
            {{--                                <label for="category">Category</label>--}}
            {{--                                <select name="category_id" id="category" class="form-control">--}}
            {{--                                    <option value="">All categories</option>--}}
            {{--                                    @foreach($data['categories'] as $category)--}}
            {{--                                        <option--}}
            {{--                                            value="{{$category['id']}}" {{ $data['current_category'] == $category['id'] ? 'selected' : '' }}>--}}
            {{--                                            {{$category['title_'.\Illuminate\Support\Facades\App::currentLocale()]}}--}}
            {{--                                        </option>--}}
            {{--                                    @endforeach--}}
            {{--                                </select>--}}
            {{--                            </div>--}}
            {{--                            <div class="mb-2">--}}
            {{--                                <label for="country">Country</label>--}}
            {{--                                <select name="country_id" id="country" class="form-control">--}}
            {{--                                    @foreach($data['countries'] as $country)--}}
            {{--                                        <option--}}
            {{--                                            value="{{$country['id']}}" {{ $data['current_country'] == $country['id'] ? 'selected' : '' }}>--}}
            {{--                                            {{$country['title_'.\Illuminate\Support\Facades\App::currentLocale()]}}--}}
            {{--                                        </option>--}}
            {{--                                    @endforeach--}}
            {{--                                </select>--}}
            {{--                            </div>--}}
            {{--                            <div class="mb-2">--}}
            {{--                                <label for="city">City</label>--}}
            {{--                                <input type="text" name="city" id="city" class="form-control"--}}
            {{--                                       value="{{$data['location']}}">--}}
            {{--                            </div>--}}
            {{--                            <div class="mb-2">--}}
            {{--                                <label for="lang">Language</label>--}}
            {{--                                <select name="lang" id="lang" class="form-control">--}}
            {{--                                    <option>Select Language</option>--}}
            {{--                                </select>--}}
            {{--                            </div>--}}
            {{--                            <div class="mb-2">--}}
            {{--                                <input type="submit" value="{{ __('main.search') }}" class="form-control">--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </form>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="col-sm-12" id="user-list">
                {{--                @if ($data['list']->isEmpty())--}}
                {{--                    <div class="card p-4">--}}
                {{--                        Nothing not found--}}
                {{--                    </div>--}}
                {{--                @else--}}
                {{--                    @foreach($data['list'] as $item)--}}
                {{--                        <div class="card user-card mb-3">--}}
                {{--                            <div class="card-body">--}}
                {{--                                <div class="user-card-mini justify-content-between">--}}
                {{--                                    <div class="">--}}
                {{--                                        @if(!$item['avatar'])--}}
                {{--                                            <img class="avatar" src="/uploads/avatars/avatar.svg">--}}
                {{--                                        @else--}}
                {{--                                            <img class="avatar" src="/uploads/avatars/{{$item['avatar']}}">--}}
                {{--                                        @endif--}}
                {{--                                    </div>--}}
                {{--                                    <div class="user-info w-100">--}}
                {{--                                        <p class="title"><b>{{$item['name']}} {{ $item['surname'] }}</b>&nbsp;--}}
                {{--                                            @foreach($item->languages as $lang)--}}
                {{--                                                <img class="user-language" src="{{ asset('/images/flags/' . $lang['key'] .'.svg') }}" title="{{ $lang['title_' . \Illuminate\Support\Facades\App::currentLocale()]}}">--}}
                {{--                                            @endforeach--}}
                {{--                                        </p>--}}
                {{--                                        <p class="category">{{$item['category']['title_'.\Illuminate\Support\Facades\App::currentLocale()]}}</p>--}}
                {{--                                        @if ($item->getRating() > 0 && $item->getRating() < 2)--}}
                {{--                                            <x-rating.stars_05/>--}}
                {{--                                        @elseif ($item->getRating() == 1)--}}
                {{--                                            <x-rating.stars_1/>--}}
                {{--                                        @elseif ($item->getRating() > 1 && $item->getRating() < 2)--}}
                {{--                                            <x-rating.stars_15/>--}}
                {{--                                        @elseif ($item->getRating() == 2)--}}
                {{--                                            <x-rating.stars_2/>--}}
                {{--                                        @elseif ($item->getRating() > 2 && $item->getRating() < 3)--}}
                {{--                                            <x-rating.stars_25/>--}}
                {{--                                        @elseif ($item->getRating() == 3)--}}
                {{--                                            <x-rating.stars_3/>--}}
                {{--                                        @elseif ($item->getRating() > 3 && $item->getRating() < 4)--}}
                {{--                                            <x-rating.stars_35/>--}}
                {{--                                        @elseif ($item->getRating() == 4)--}}
                {{--                                            <x-rating.stars_4/>--}}
                {{--                                        @elseif ($item->getRating() > 4 && $item->getRating() < 5)--}}
                {{--                                            <x-rating.stars_45/>--}}
                {{--                                        @elseif ($item->getRating() == 5)--}}
                {{--                                            <x-rating.stars_5/>--}}
                {{--                                        @endif--}}
                {{--                                    </div>--}}
                {{--                                    <div class="open-profile text-end">--}}
                {{--                                        <a href="#" class="mb-2" data-bs-toggle="modal" data-bs-target="#newReview"--}}
                {{--                                           onclick="openReviewModal({{$item['id']}})">{{ __('main.add_review') }}</a>--}}
                {{--                                        <a href="/profile/{{$item['id']}}"--}}
                {{--                                           class="btn btn-secondary">{{ __('main.profile') }}</a>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    @endforeach--}}
                {{--                @endif--}}
                {{--                    {{ $data['list']->appends(request()->query())->links() }}--}}
                {{--                @endif--}}
            </div>
        </div>
    </div>


    <!-- new review -->
    <div class="modal fade" id="newReview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" action="{{ route('review.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ __('main.add_review') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>{{ __('main.name') }}</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3 align-items-center d-flex">
                            <label class="mr-3">Rank&nbsp;&nbsp;&nbsp;</label>
                            <div class="star" id="rank_1" onclick="rank(1)"></div>
                            <div class="star" id="rank_2" onclick="rank(2)"></div>
                            <div class="star" id="rank_3" onclick="rank(3)"></div>
                            <div class="star" id="rank_4" onclick="rank(4)"></div>
                            <div class="star" id="rank_5" onclick="rank(5)"></div>
                        </div>
                        <div class="mb-3">
                            <label>Text</label>
                            <textarea name="text" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <input type="hidden" name="rank" id="rank" required>
                        <input type="hidden" name="user_id" id="user_id" required>
                        <input type="submit" class="btn btn-primary" value="{{__('main.send')}}">
                    </div>
                </form>
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
            console.log(bounds)
            let max_lat = bounds.zb.hi
            let min_lat = bounds.zb.lo
            let max_lng = bounds.Ra.hi
            let min_lng = bounds.Ra.lo
            var userList = []
            users.forEach(user => {
                console.log(user)
                lat = +user.geo.lat
                lng = +user.geo.lng
                if (lat > min_lat && lat < max_lat && lng > min_lng && lng < max_lng) {
                    userList.push(user)
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
            showUsers(userList)

        })

    }


    function showUsers(list) {
        let listBlock = document.getElementById('user-list')
        listBlock.innerHTML = ''
        listBlock.style.display = 'none'
        if (list.length === 0) {
            listBlock.innerHTML = '<div class="card p-4">Nothing not found</div>'
        } else {
            list.forEach(user => {
                console.log(user)
                listBlock.innerHTML += `<div class="card user-card mb-3">
                <div class="card-body">
                    <div class="user-card-mini justify-content-between" id="user-card-${user['id']}">


</div></div></div>`
                if (!user.avatar) {
                    document.getElementById('user-card-' + user.id).innerHTML = `<img class="avatar" src="/uploads/avatars/avatar.svg"><div class="user-info w-100" id="user-info-${user.id}"></div>`
                } else {
                    document.getElementById('user-card-' + user.id).innerHTML = `<img class="avatar b-0" src="/uploads/avatars/${user['avatar']}"><div class="user-info w-100" id="user-info-${user.id}"></div>`
                }
                document.getElementById('user-info-' + user.id).innerHTML = `<p class="title">${(user.surname !== null) ? user.name + ' ' + user.surname : user.name}<span id="languages-${user.id}"</p>  `
                document.getElementById('user-info-' + user.id).innerHTML += `<p class="category">${user.category.title_{{\Illuminate\Support\Facades\App::currentLocale()}}}</p>`
                document.getElementById('user-info-' + user.id).innerHTML += `<p class="subcategory">`
                user.subcategory.forEach(service => {
                    document.getElementById('user-info-' + user.id).innerHTML += service.title_{{ \Illuminate\Support\Facades\App::currentLocale() }} + ', '
                })
                document.getElementById('user-info-' + user.id).innerHTML += `</p>`

                if ((user.rating > 0) && (user.rating < 1)) {
                    document.getElementById('user-info-' + user.id).innerHTML += `<x-rating.stars_05/>`
                } else if (user.rating === 1) {
                    document.getElementById('user-info-' + user.id).innerHTML += `<x-rating.stars_1/>`
                } else if ((user.rating > 1) && (user.rating < 2)) {
                    document.getElementById('user-info-' + user.id).innerHTML += `<x-rating.stars_15/>`
                } else if (user.rating === 2) {
                    document.getElementById('user-info-' + user.id).innerHTML += `<x-rating.stars_2/>`
                } else if ((user.rating > 2) && (user.rating < 3)) {
                    document.getElementById('user-info-' + user.id).innerHTML += `<x-rating.stars_25/>`
                } else if (user.rating === 3) {
                    document.getElementById('user-info-' + user.id).innerHTML += `<x-rating.stars_3/>`
                } else if ((user.rating > 3) && (user.rating < 4)) {
                    document.getElementById('user-info-' + user.id).innerHTML += `<x-rating.stars_35/>`
                } else if (user.rating === 4) {
                    document.getElementById('user-info-' + user.id).innerHTML += `<x-rating.stars_4/>`
                } else if ((user.rating > 4) && (user.rating < 5)) {
                    document.getElementById('user-info-' + user.id).innerHTML += `<x-rating.stars_45/>`
                } else if (user.rating === 5) {
                    document.getElementById('user-info-' + user.id).innerHTML += `<x-rating.stars_5/>`
                }
                //Add flags
                document.getElementById('languages-' + user.id).innerHTML = ''
                user.languages.forEach(lang => {
                    document.getElementById('languages-' + user.id).innerHTML += `<img class="user-language mx-1" src="/images/flags/${lang.key}.svg" title="${lang.title_{{ \Illuminate\Support\Facades\App::currentLocale() }}}">`
                })
                let cur_lang = {{ $data['current_language'] }};
                if (cur_lang === 0) {
                    cur_lang = ''
                }
                document.getElementById('user-card-' + user.id).innerHTML += '<div>'
                document.getElementById('user-card-' + user.id).innerHTML += `<a href="#" class="mb-2 mx-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#newReview" onclick="openReviewModal(${user.id})">{{ __('main.add_review') }}</a>`
                let profileLink = `/profile/${user.id}?lang=${cur_lang}`
                document.getElementById('user-card-' + user.id).innerHTML += `<a href="${profileLink}" class="btn btn-secondary">{{ __('main.profile') }}</a>`
                document.getElementById('user-card-' + user.id).innerHTML += '</div>'
            })
        }
        listBlock.style.display = 'inline-block'

    }


    function openReviewModal(user_id) {
        let users = @json($data['users']);
        let user = users.filter(us => us.id === user_id)[0]
        let surname = (user['surname'] !== null) ? user['surname'] : ''
        document.querySelector('div.modal-header h5').innerHTML = user['name'] + ' ' + surname
        document.getElementById('user_id').value = user_id

    }

    function rank(rank) {
        let stars = document.getElementsByClassName('star')
        for (let i = 0; i < stars.length; i++) {
            stars[i].style.background = '#c6c3c3'
        }
        for (let i = 0; i < rank; i++) {
            stars[i].style.background = '#f5a126'
            document.getElementById('rank').value = rank
        }
    }


    window.addEventListener('load', () => {
        let locale = "{{ \Illuminate\Support\Facades\App::currentLocale() }}"
        let categories = @json($data['categories']);
        let subcategories = @json($data['subcategories']);
        let categoryId = "{{ $data['current_category'] }}";
        let subcategoryId = "{{ $data['current_subcategory'] }}";
        let btn = document.getElementById('show-categories')
        let category = Object
        let subcategory = Object
        if ((categoryId) && (!subcategoryId)){
            for (cat in categories){
                if (categories[cat]['id'] === +categoryId){
                    category = categories[cat]
                }
            }
            btn.innerHTML = `${category['title_' + locale]}`
        }
        if ((subcategoryId) && (categoryId)) {
            for (sub in subcategories){
                if (subcategories[sub]['id'] === +subcategoryId){
                    subcategory = subcategories[sub]
                }
            }
            btn.innerHTML = `${subcategory['title_' + locale]}`
        }

    })


</script>



