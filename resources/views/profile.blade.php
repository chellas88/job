@extends('layouts.app')
@section('head')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxEmjg-EGbt0m8Dr_cCWgO7IvcqA89fEU"
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
                        <div class="col-12 col-lg-9">
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
                            <button class="btn btn-secondary show-description my-2" data-bs-toggle="modal" data-bs-target="#descriptionModal">
                                {{ __('main.show_information') }}
                            </button>
                            <hr>
                            <div class="profile-description">
                                <h5>{{ __('main.about_me') }}</h5>
                                {!! $data['user']['description_' . \Illuminate\Support\Facades\App::currentLocale()] !!}
                            </div>
                        </div>
                        <div class="profile-contacts col-12 col-lg-3">
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



    <!-- Modal -->
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen-xl-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $data['user']['name'] }} {{ $data['user']['surname'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! $data['user']['description_' . \Illuminate\Support\Facades\App::currentLocale()] !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('main.close') }}</button>
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

    window.addEventListener('load', () => {
        initMap()
    })
</script>
