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
            <div class="col-12">
                <div class="user-header">
                    <div class="">
                    @if(!$data['user']['avatar'])
                        <img class="avatar" src="/uploads/avatars/avatar.svg">
                    @else
                        <img class="avatar" src="/uploads/avatars/{{$data['user']['avatar']}}">
                    @endif
                    </div>
                    <div class="mx-3">
                    <h4>{{ $data['user']['name'] }} {{ $data['user']['surname'] }}</h4>
                    @if ($data['category'])
                        <p>{{$data['category']['title']}}</p>
                    @endif
                    </div>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="user-line-tab" data-bs-toggle="tab"
                               data-bs-target="#user-info"
                               role="tab" aria-controls="user-info" aria-selected="true">{{ __('main.main_info') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-line-tab" data-bs-toggle="tab"
                               data-bs-target="#profile"
                               role="tab" aria-controls="profile" aria-selected="true">{{ __('main.profile') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="address-line-tab" data-bs-toggle="tab" data-bs-target="#address"
                               role="tab"
                               aria-controls="address" aria-selected="false">{{ __('main.address') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="languages-line-tab" data-bs-toggle="tab" data-bs-target="#languages"
                               role="tab"
                               aria-controls="contacts" aria-selected="false">{{ __('main.languages') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contacts-line-tab" data-bs-toggle="tab" data-bs-target="#contacts"
                               role="tab"
                               aria-controls="contacts" aria-selected="false">{{ __('main.contacts') }}</a>
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
                                    <h4>{{ __('main.main_info') }}</h4>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('main.name') }}</label>
                                        <input type="text" name="name" id="name" value="{{$data['user']['name']}}"
                                               class="form-control @error('name') is-invalid @enderror"
                                        >
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    @if ($data['user']['role'] == 'person')
                                        <div class="mb-3">
                                            <label for="surname" class="form-label">{{ __('main.surname') }}</label>
                                            <input type="text" name="surname" id="surname" value="{{$data['user']['surname']}}"
                                                   class="form-control @error('surname') is-invalid @enderror"
                                            >
                                            @error('surname')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('main.email') }}</label>
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
                                    <input type="submit" value="{{ __('main.save') }}" class="btn btn-secondary">
                                </form>
                            </div>
                            <div class="mb-4">
                                <h4>{{ __('main.avatar') }}</h4>
                                <div class="mb-3">
                                    <form method="POST" action="{{ route('upload-avatar') }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <label for="avatar" class="form-label">{{ __('main.change_avatar') }}</label>
                                        <input class="form-control mb-3" type="file" id="avatar" name="avatar">
                                        @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <input type="submit" value="{{ __('main.upload') }}" class="btn btn-secondary">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-line-tab">
                            <div class="m-3 border-info">
                                <h5>{{ __('main.services') }}</h5>
                                <div id="service-list" class="d-inline">
                                    @foreach($data['my_services'] as $myserv)
                                        <span id="serv_{{$myserv['id']}}">
                                        {{$myserv['title_'.\Illuminate\Support\Facades\App::currentLocale()]}}
                                        <i onclick="removeService({{$myserv['id']}}, '{{\Illuminate\Support\Facades\App::currentLocale()}}')">X</i></span>
                                    @endforeach
                                </div>
                                <a class="nav-link dropdown-toggle d-inline" href="#"
                                   id="navbarDarkDropdownMenuService"
                                   role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ __('main.add_service') }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark"
                                    aria-labelledby="navbarDarkDropdownMenuService" id="service-menu">
                                    @foreach($data['services'] as $service)
                                        <li id="newservice_{{$service['id']}}">
                                            <a onclick="addService({{$service['id']}}, '{{\Illuminate\Support\Facades\App::currentLocale()}}')"
                                               class="dropdown-item" href="#">
                                                {{$service['title_'.\Illuminate\Support\Facades\App::currentLocale()]}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <profile-tab :user-category="{{ $data['user']['category'] }}"
                                         :services="{{ json_encode($data['services'], true) }}"
                                         :user-services="{{ json_encode($data['user']->services, true) }}"
                                         locale="{{ \Illuminate\Support\Facades\App::currentLocale() }}"
                                         :user-languages="{{ json_encode($data['user']->languages, true) }}"
                                         :user-info="{{ json_encode($data['user'], true) }}"
                                         :translate="{{ json_encode($data['translate']) }}"
                            >
                            </profile-tab>
                        </div>
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-line-tab">
                            <form method="POST" action="{{route('save-address')}}">
                                @csrf
                                <div class="mb-3">
                                    <label for="country">{{ __('main.country') }}</label>
                                    <input type="text" id="country" name="country" class="form-control" required
                                           value="{{ $data['user']->country }}">

                                </div>
                                <div class="mb-3">
                                    <label for="state">{{ __('main.state') }}</label>
                                    <input type="text" id="state" name="state" class="form-control"
                                           placeholder="{{ __('main.input_state') }}"
                                           value="{{ $data['user']['state'] }}"
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="city">{{ __('main.city') }}</label>
                                    <input type="text" id="city" name="city"
                                           class="form-control @error('city') is-invalid @enderror"
                                           placeholder="{{ __('main.input_city') }}"
                                           value="{{ $data['user']['city'] }}"
                                    >
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="address">{{ __('main.address') }}</label>
                                    <input type="text" id="address" name="address" class="form-control"
                                           placeholder="{{ __('main.input_address') }}"
                                           value="{{$data['user']['address']}}">
                                </div>
                                <div class="mb-3">
                                    <input type="submit" value="{{ __('main.save') }}" class="btn btn-secondary">
                                </div>

                            </form>
                        </div>
                        <div class="tab-pane fade" id="languages" role="tabpanel"
                             aria-labelledby="languages-line-tab">
                            <div class="languages lang-list">
                                <p>{{ __('main.langlist_text') }}</p>
                                <languages :my-languages="{{ json_encode($data['my_languages'], true) }}"
                                           :languages="{{ json_encode($data['languages'], true) }}"
                                           locale="{{ \Illuminate\Support\Facades\App::currentLocale() }}"
                                           :translate="{{ json_encode($data['translate'], true) }}"></languages>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contacts" role="tabpanel"
                             aria-labelledby="contacts-line-tab">
                            <p>{{ __('main.contacts_text') }}</p>
                            <form method="POST" action="{{route('save-contacts')}}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <label for="phone">{{ __('main.phone') }}</label>
                                        <input type="text" id="phone" name="phone" class="form-control"
                                               @if ($data['user']->contacts)
                                               value="{{ $data['user']->contacts['phone'] }}"
                                            @endif
                                        >
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="viber">{{ __('main.viber') }}</label>
                                        <input type="text" id="viber" name="viber" class="form-control"

                                               @if ($data['user']->contacts)
                                               value="{{ $data['user']->contacts['viber'] }}"
                                            @endif
                                        >
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="telegram">{{ __('main.telegram') }}</label>
                                        <input type="text" id="telegram" name="telegram" class="form-control"

                                               @if ($data['user']->contacts)
                                               value="{{ $data['user']->contacts['telegram'] }}"
                                            @endif
                                        >
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="whatsapp">{{ __('main.whatsapp') }}</label>
                                        <input type="text" id="whatsapp" name="whatsapp" class="form-control"

                                               @if ($data['user']->contacts)
                                               value="{{ $data['user']->contacts['whatsapp'] }}"
                                            @endif
                                        >
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="facebook">{{ __('main.facebook') }}</label>
                                        <input type="text" id="facebook" name="facebook" class="form-control"

                                               @if ($data['user']->contacts)
                                               value="{{ $data['user']->contacts['facebook'] }}"
                                            @endif
                                        >
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="instagram">{{ __('main.instagram') }}</label>
                                        <input type="text" id="instagram" name="instagram" class="form-control"

                                               @if ($data['user']->contacts)
                                               value="{{ $data['user']->contacts['instagram'] }}"
                                            @endif
                                        >
                                    </div>
                                </div>
                                <input class="btn btn-secondary" type="submit" value="{{ __('main.save') }}">
                            </form>

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


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mainBtn = document.getElementById('user-line-tab')
        const contactsBtn = document.getElementById('contacts-line-tab')
        const addrBtn = document.getElementById('address-line-tab')
        const langBtn = document.getElementById('languages-line-tab')
        const profileBtn = document.getElementById('profile-line-tab')
        // const servicesBtn = document.getElementById('services-line-tab')


        mainBtn.addEventListener('click', () => {
            window.location.hash = '#main'
        })
        addrBtn.addEventListener('click', () => {
            window.location.hash = '#addr'
        })
        langBtn.addEventListener('click', () => {
            window.location.hash = '#lang'
        })
        contactsBtn.addEventListener('click', () => {
            window.location.hash = '#contacts'
        })
        // servicesBtn.addEventListener('click', () => {
        //     window.location.hash = '#services'
        // })
        profileBtn.addEventListener('click', () => {
            window.location.hash = '#profile'
        })

        let hash = window.location.hash.replace('#', '')

        if (hash === 'contacts') {
            contactsBtn.click()
        } else if (hash === 'main') {
            mainBtn.click()
        } else if (hash === 'addr') {
            addrBtn.click()
        } else if (hash === 'lang') {
            langBtn.click()
        } else if (hash === 'services') {
            servicesBtn.click()
        } else if (hash === 'profile') {
            profileBtn.click()
        }

    })
</script>



