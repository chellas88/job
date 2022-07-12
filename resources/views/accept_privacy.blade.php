@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="row py-2">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        {{ __('main.user_card') }}
                    </div>
                    <div class="card-body new-user-card">
                        <p>{{ __('main.name') }}: <i>{{ $user['name'] }}</i></p>
                        <p>{{ __('main.email') }}: <i>{{ $user['email'] }}</i></p>
                        <p>{{ __('main.country') }}:
                            <i>{{ $user->country['title_'.\Illuminate\Support\Facades\App::currentLocale()] }}</i></p>
                        <p>{{ __('main.category') }}:
                            <i>{{ $user->category['title_'. \Illuminate\Support\Facades\App::currentLocale()] }}</i></p>
                        <form method="post" action="{{ route('accept_policy') }}">
                            @csrf
                            <input type="checkbox" name="policy" id="policy" required>
                            <input type="hidden" name="user" value="{{$user['id']}}">
                            <label for="policy"> {{ __('main.accept_policy') }}</label>
                            <p><input type="submit" value="{{ __('main.accept') }}" class="btn btn-secondary mt-3"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
