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
                    <div class="profile-avatar">
                        @if(!$data['user']['avatar'])
                            <img class="avatar" src="/uploads/avatars/avatar.svg">
                        @else
                            <img class="avatar" src="/uploads/avatars/{{$data['user']['avatar']}}">
                        @endif
                    </div>
                    <div class="profile-content row">
                        <div class="col-8">
                            <h4>{{$data['user']['name']}} {{ $data['user']['surname'] }}</h4>
                            <p>
                                <span>{{$data['category']['title_'.\Illuminate\Support\Facades\App::currentLocale()]}}</span>
                            </p>
                            <p><b>{{ __('main.services') }}: </b>
                                @foreach($data['services'] as $service)
                                    {{$service['title_'.\Illuminate\Support\Facades\App::currentLocale()]}},
                                @endforeach
                            </p>
                            <p><b>{{ __('main.speaking') }}: </b>
                                @foreach($data['languages'] as $lang)
                                    {{$lang['title_'.\Illuminate\Support\Facades\App::currentLocale()]}},
                                @endforeach
                            </p>
                        </div>
                        <div class="profile-contacts col-4">
                            <h5> {{ __('main.contacts') }}</h5>
                            <div class="btn btn-phone w-100 mb-2" id="phone"
                                    onclick="getContact('phone')">{{ __('main.show_phone') }}</div>
                            <div class="btn btn-email w-100 mb-2" id="email"
                                    onclick="getContact('email')">{{ __('main.show_email') }}</div>
                            @if ($data['user']->contacts->viber)
                                <div class="btn btn-viber w-100 mb-2" id="viber"
                                        onclick="getContact('viber')">{{ __('main.show_viber') }}</div>
                            @endif
                            @if ($data['user']->contacts->whatsapp)
                                <div class="btn btn-whatsapp w-100 mb-2" id="whatsapp"
                                     onclick="getContact('whatsapp')">{{ __('main.show_whatsapp') }}</div>
                            @endif
                            @if ($data['user']->contacts->telegram)
                                <div class="btn btn-telegram w-100 mb-2" id="telegram"
                                     onclick="getContact('telegram')">{{ __('main.show_telegram') }}</div>
                            @endif
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

<script>
    function getContact(type) {
        let user = @json($data['user']);
        $.ajax({
            method: 'post',
            url: '/{{ \Illuminate\Support\Facades\App::currentLocale() }}/getContact',
            data: {
                'type': type,
                '_token': document.head.querySelector('meta[name="csrf-token"]').content,
                'user_id': user.id
            },
            success: function (response) {
                console.log(response)
                document.getElementById(type).innerHTML = response.val


            }
        })
    }
</script>
