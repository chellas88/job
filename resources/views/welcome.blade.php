@extends('layouts.app')

@section('head')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxEmjg-EGbt0m8Dr_cCWgO7IvcqA89fEU&callback=initMap"
            async defer></script>
@endsection

@section('content')
    <section class="main-block">
        <div id="main_map"></div>
        <div class="search active">
        <form id="search-form" method="GET" action="/search">
            @csrf
            <div class="mb-3">
                <label for="category_id">Category</label>
                <select type="text" class="form-control" id="category_id" name="category_id">
                    <option value="" selected>All categories</option>
                    @foreach($category as $item)
                        <option
                            value="{{ $item['id'] }}" {{ old('category_id') == $item['id'] ? "selected" : ''}}>{{$item['title']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="country_id">Country</label>
                <select type="text" class="form-control" id="country_id" name="country_id" required>
                    <option value="" selected disabled>Select Country</option>
                    @foreach($country as $item)
                        <option
                            value="{{ $item['id'] }}" {{ old('country_id') == $item['id'] ? "selected" : ''}}>{{$item['title']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="city">City</label>
                <input type="text" class="form-control @error('city') is-invalid @enderror"
                       placeholder="input city" id="city"
                       name="city" value="{{ old('city') }}" required>
                @error('city')
                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="lang">Language</label>
                <select type="text" class="form-control" id="lang" name="lang">
                    <option value="0">Select Language</option>
                </select>
            </div>

            <input type="submit" value="Search" class="btn">

        </form>
            <div class="search-show-hide" id="showHideSearch"><i class='bx bx-chevron-left' ></i></div>
        </div>
    </section>
{{--    <section class="main-block">--}}
{{--        <div class="container py-5">--}}
{{--            <div class="row align-items-center py-lg-5">--}}
{{--                <div class="col-lg-5 mb-5 mb-lg-0 crm-text">--}}
{{--                    <form id="search-form" method="GET" action="/search">--}}
{{--                        @csrf--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="category_id">Category</label>--}}
{{--                            <select type="text" class="form-control" id="category_id" name="category_id">--}}
{{--                                <option value="" selected>All categories</option>--}}
{{--                                @foreach($category as $item)--}}
{{--                                    <option--}}
{{--                                        value="{{ $item['id'] }}" {{ old('category_id') == $item['id'] ? "selected" : ''}}>{{$item['title']}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="country_id">Country</label>--}}
{{--                            <select type="text" class="form-control" id="country_id" name="country_id" required>--}}
{{--                                <option value="" selected disabled>Select Country</option>--}}
{{--                                @foreach($country as $item)--}}
{{--                                    <option--}}
{{--                                        value="{{ $item['id'] }}" {{ old('country_id') == $item['id'] ? "selected" : ''}}>{{$item['title']}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="city">City</label>--}}
{{--                            <input type="text" class="form-control @error('city') is-invalid @enderror"--}}
{{--                                   placeholder="input city" id="city"--}}
{{--                                   name="city" value="{{ old('city') }}" required>--}}
{{--                            @error('city')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="lang">Language</label>--}}
{{--                            <select type="text" class="form-control" id="lang" name="lang">--}}
{{--                                <option value="0">Select Language</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                        <input type="submit" value="Search" class="btn">--}}

{{--                    </form>--}}
{{--                </div>--}}
{{--                <div class="col-lg-7 text-center">--}}
{{--                    <img class="crm-img" src="{{ asset('/images/main.png') }}">--}}
{{--                    @if(!auth()->user())--}}
{{--                        <a href="/register" class="text-center btn signup">Sign Up Free</a>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <img class="w-100 bg-bottom" src="{{ asset('/images/main-block-bottom.svg') }}">--}}
{{--    </section>--}}

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
                        @foreach($reviews as $index => $review)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }} py-5">
                                <div class="review">
                                    <div class="review-content">
                                        @if($review['for_user']['avatar'])
                                            <img src="{{asset('/uploads/avatars/'.$review['for_user']['avatar'])}}" class="d-block w-100 avatar">
                                        @else
                                            <img src="{{asset('/uploads/avatars/avatar.svg')}}" class="d-block w-100 avatar">
                                        @endif
                                        <div class="review-rank text-center">
                                            @if ($review['rank'] == 5)
                                                <x-rating.stars_5 />
                                            @elseif ($review['rank'] == 4)
                                                <x-rating.stars_4 />
                                            @elseif ($review['rank'] == 3)
                                                <x-rating.stars_3 />
                                            @elseif ($review['rank'] == 2)
                                                <x-rating.stars_2 />
                                            @elseif ($review['rank'] == 1)
                                                <x-rating.stars_1 />
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
    {{--    <section class="my-3">--}}
    {{--        <div class="container-fluid alert-danger">--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-4 text-center py-4">--}}
    {{--                    alksdfj--}}
    {{--                </div>--}}
    {{--                <div class="col-4 text-center py-4">--}}
    {{--                    alksdfj--}}
    {{--                </div>--}}
    {{--                <div class="col-4 text-center py-4">--}}
    {{--                    alksdfj--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}
@endsection


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
