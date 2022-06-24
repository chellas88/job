@extends('layouts.app')

@section('content')
    <section class="main-block">
        <div class="container py-5">
            <div class="row align-items-center py-lg-5">
                <div class="col-lg-5 mb-5 mb-lg-0 crm-text">
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
                </div>
                <div class="col-lg-7 text-center">
                    <img class="crm-img" src="{{ asset('/images/main.png') }}">
                    @if(!auth()->user())
                        <a href="/register" class="text-center btn signup">Sign Up Free</a>
                    @endif
                </div>
            </div>
        </div>
        <img class="w-100 bg-bottom" src="{{ asset('/images/main-block-bottom.svg') }}">
    </section>
    <section class="most-popular my-3">
        <div class="container py-4 text-center">
            <div class="row">
                <div class="col-12 mb-3">
                    <h1>Most Popular</h1>

                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="icons/sprites.svg#developer-icon"></use>
                        </svg>
                        <span>Developer</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/icons/sprites.svg#government-icon"></use>
                        </svg>
                        <span>Government</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/icons/sprites.svg#medical-icon"></use>
                        </svg>
                        <span>Medicine</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/icons/sprites.svg#education-icon"></use>
                        </svg>
                        <span>Education</span>
                    </div>
                </div>

                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/icons/sprites.svg#mechanic-icon"></use>
                        </svg>
                        <span>Auto Mechanic</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/icons/sprites.svg#plumber-icon"></use>
                        </svg>
                        <span>Plumber</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/icons/sprites.svg#translator-icon"></use>
                        </svg>
                        <span>Translator</span>
                    </div>
                </div>
                <div class="col-3 my-5">
                    <div class="popular-item">
                        <svg class="popular-icon">
                            <use xlink:href="/icons/sprites.svg#logistic-icon"></use>
                        </svg>
                        <span>Logistic</span>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="my-3">
        <div class="container-fluid alert-danger">
            <div class="row">
                <div class="col-4 text-center py-4">
                    alksdfj
                </div>
                <div class="col-4 text-center py-4">
                    alksdfj
                </div>
                <div class="col-4 text-center py-4">
                    alksdfj
                </div>
            </div>
        </div>
    </section>
@endsection


