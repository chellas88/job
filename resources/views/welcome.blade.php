@extends('layouts.app')

@section('head')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxEmjg-EGbt0m8Dr_cCWgO7IvcqA89fEU&callback=initMap"
            async defer></script>
@endsection

@section('content')
    <section class="main-block">
        <div id="main_map"></div>
        <div class="search active">
            <form id="search-form" method="GET" action="{{route('search')}}">
                @csrf
                <div class="mb-3">
{{--                    <label for="category_id">{{ __('main.categories') }}</label>--}}
                    <select type="text" class="form-control" id="category_id" name="category_id">
                        <option value="" selected>{{ __('main.all_category') }}</option>
                        @if(!$category->isEmpty())
                            @foreach($category as $item)
                                <option
                                    value="{{ $item['id'] }}" {{ old('category_id') == $item['id'] ? "selected" : ''}}>{{$item['title_' . \Illuminate\Support\Facades\App::currentLocale()]}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="mb-3">
{{--                    <label for="country_id">Country</label>--}}
                    <select type="text" class="form-control" id="country_id" name="country_id" required>
                        <option value="" selected disabled>{{ __('main.select_country') }}</option>
                        @foreach($country as $item)
                            <option value="{{ $item['id'] }}" {{ old('country_id') == $item['id'] ? "selected" : ''}}>
                                {{$item['title_' . \Illuminate\Support\Facades\App::currentLocale()]}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
{{--                    <label for="city">{{ __('main.city') }}</label>--}}
                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                           placeholder="{{ __('main.city') }}" id="city"
                           name="city" value="{{ old('city') }}" required>
                    @error('city')
                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                    @enderror
                </div>
                <div class="mb-3">
{{--                    <label for="lang">Language</label>--}}
                    <select type="text" class="form-control" id="lang" name="lang">
                        <option value="0">{{ __('main.select_language') }}</option>
                    </select>
                </div>

                <input type="submit" value="{{ __('main.search') }}" class="btn">

            </form>
            <div class="search-show-hide" id="showHideSearch"><i class='icon-chevron-left'></i></div>
        </div>
    </section>


    {{--    RECOMENDED COMPANIES--}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 recommended-companies">
                <div class="title">{{ __('main.recommended') }}</div>
                <ul class="m-0">
                    @foreach($recommended as $rec)
                        <li>
                            <div class="px-2">
                                @if($rec['avatar'])
                                    <img src="{{asset('/uploads/avatars/'.$rec['avatar'])}}" class="d-block avatar">
                                @else
                                    <img src="{{asset('/uploads/avatars/avatar.svg')}}" class="d-block avatar">
                                @endif
                            </div>
                            <div class="align-items-center">
                                <a href="{{ \Illuminate\Support\Facades\App::currentLocale() }}/profile/{{$rec['id']}}">{{$rec['name']}}</a>
                                <p>{{$rec['category']['title_'.\Illuminate\Support\Facades\App::currentLocale()]}}</p>
                                @if ($rec['rating'] > 0 && $rec['rating'] < 2)
                                    <x-rating.stars_05/>
                                @elseif ($rec['rating'] == 1)
                                    <x-rating.stars_1/>
                                @elseif ($rec['rating'] > 1 && $rec['rating'] < 2)
                                    <x-rating.stars_15/>
                                @elseif ($rec['rating'] == 2)
                                    <x-rating.stars_2/>
                                @elseif ($rec['rating'] > 2 && $rec['rating'] < 3)
                                    <x-rating.stars_25/>
                                @elseif ($rec['rating'] == 3)
                                    <x-rating.stars_3/>
                                @elseif ($rec['rating'] > 3 && $rec['rating'] < 4)
                                    <x-rating.stars_35/>
                                @elseif ($rec['rating'] == 4)
                                    <x-rating.stars_4/>
                                @elseif ($rec['rating'] > 4 && $rec['rating'] < 5)
                                    <x-rating.stars_45/>
                                @elseif ($rec['rating'] == 5)
                                    <x-rating.stars_5/>
                                @endif
                            </div>
                        </li>

                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{--        POPULAR--}}
    <section class="most-popular my-3">
        <div class="container py-4 text-center">
            <div class="row">
                <div class="col-12 mb-3">
                    <h1>Most Popular</h1>

                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/images/sprites.svg#developer-icon"></use>
                        </svg>
                        <span>Developer</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/images/sprites.svg#government-icon"></use>
                        </svg>
                        <span>Government</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/images/sprites.svg#medical-icon"></use>
                        </svg>
                        <span>Medicine</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/images/sprites.svg#education-icon"></use>
                        </svg>
                        <span>Education</span>
                    </div>
                </div>

                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/images/sprites.svg#mechanic-icon"></use>
                        </svg>
                        <span>Auto Mechanic</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/images/sprites.svg#plumber-icon"></use>
                        </svg>
                        <span>Plumber</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/images/sprites.svg#translator-icon"></use>
                        </svg>
                        <span>Translator</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/images/sprites.svg#logistic-icon"></use>
                        </svg>
                        <span>Logistic</span>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <div class="counter-block container-fluid">
        <div class="row justify-content-around text-center">
            <div class="col-4 counter-item">
                <h4>Persons</h4>
                <div class="counter" data-digits-counter>{{ $personsCount }}</div>
            </div>
            <div class="col-4 counter-item dark">
                <h4>Companies</h4>
                <div class="counter" data-digits-counter>{{ $companiesCount }}</div>
            </div>
            <div class="col-4 counter-item">
                <h4>Countries</h4>
                <div class="counter" data-digits-counter>{{ $countriesCount }}</div>
            </div>
        </div>
    </div>



    {{--    REVIEWS--}}
    <div class="container-fluid main-block reviews-block">
        <img class="w-100 bg-top" src="{{ asset('/images/main-block-top.svg') }}">
        <div class="row py-5 justify-content-center reviews-row">
            <div class="col-md-8">
                <h3>Last Reviews</h3>
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        @if ($reviews)
                            @foreach($reviews as $index => $review)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }} py-5">
                                    <div class="review">
                                        <div class="review-content">
                                            @if($review['for_user']['avatar'])
                                                <img src="{{asset('/uploads/avatars/'.$review['for_user']['avatar'])}}"
                                                     class="d-block w-100 avatar">
                                            @else
                                                <img src="{{asset('/uploads/avatars/avatar.svg')}}"
                                                     class="d-block w-100 avatar">
                                            @endif
                                            <h5 class="text-center">{{ $review['for_user']['name'] }} {{ $review['for_user']['surname'] }}</h5>
                                            <div class="review-rank text-center mb-2">
                                                @if ($review['rank'] == 5)
                                                    <x-rating.stars_5/>
                                                @elseif ($review['rank'] == 4)
                                                    <x-rating.stars_4/>
                                                @elseif ($review['rank'] == 3)
                                                    <x-rating.stars_3/>
                                                @elseif ($review['rank'] == 2)
                                                    <x-rating.stars_2/>
                                                @elseif ($review['rank'] == 1)
                                                    <x-rating.stars_1/>
                                                @endif
                                            </div>
                                            <div class="review-text text-center">
                                                {{$review['text']}}
                                            </div>
                                            <div class="review-author text-end pt-3">
                                                {{$review['name']}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <img class="w-100 bg-bottom" src="{{ asset('/images/main-block-bottom.svg') }}">

    </div>


@endsection

<script>
    window.addEventListener("load", windowLoad)
    function windowLoad(){
        function digitsCountersInit(digitsCountersItems){
            let digitsCounters = digitsCountersItems ? digitsCountersItems : document.querySelectorAll("[data-digits-counter]")
            if (digitsCounters){
                digitsCounters.forEach(digitsCounter => {
                    digitsCounterAnimate(digitsCounter)
                })
            }
        }
        function digitsCounterAnimate(digitsCounter){
            let startTimestamp = null
            const duration = parseInt(digitsCounter.dataset.digitsCounter) ? parseInt(digitsCounter.dataset.digitsCounter) : 500
            const startValue = parseInt(digitsCounter.innerHTML)
            console.log(startValue)
            const startPosition = 0
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp
                const progress = Math.min((timestamp - startTimestamp) / duration, 1)
                digitsCounter.innerHTML = Math.floor(progress * (startPosition + startValue))
                if (progress < 1){
                    window.requestAnimationFrame(step)
                }
            }
            window.requestAnimationFrame(step)
        }
        // digitsCountersInit()
        let options = {
            threshold: 0.3
        }
        let observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting){
                    const targetElement = entry.target
                    const digitsCountersItems = targetElement.querySelectorAll("[data-digits-counter]")
                    if (digitsCountersItems.length){
                        digitsCountersInit(digitsCountersItems)
                    }
                }
            })
        }, options)

        let sections = document.querySelectorAll('.counter-block')
        if (sections.length){
            sections.forEach(section => {
                observer.observe(section)
            })
        }
    }
</script>


<script>
    let center_lat = 50.450001;
    let center_lng = 30.523333;

    function initMap() {
        // The location of Uluru
        const center = {lat: center_lat, lng: center_lng};
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("main_map"), {
            zoom: 15,
            center: center,
            fullscreenControl: false,
            mapTypeControl: false,
            streetViewControl: false

        });
        // The marker, positioned at Uluru


    }

    window.initMap = initMap;
</script>
