@extends('layouts.app')

@section('content')


    <div class="col main-block">

        <img class="w-100 bg-bottom" src="{{ asset('/images/main-block-bottom.svg') }}">
    </div>
    <div class="container auth-block">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end">{{ __('main.account_type') }}</label>
                                <div class="col-md-6">
                                    <input type="radio" value="person" name="role" id="person" checked>
                                    <input type="radio" value="company" name="role" id="company">
                                    <label for="person" class="person" onclick="showSurname('person')">{{ __('main.person') }}</label>
                                    <label for="company" class="company" onclick="showSurname('company')">{{ __('main.company') }}</label>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end company-name">{{ __('main.name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 surname-block">
                                <label for="surname" class="col-md-4 col-form-label text-md-end">{{ __('main.surname') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text"
                                           class="form-control @error('surname') is-invalid @enderror" name="surname"
                                           value="{{ old('surname') }}" required autocomplete="surname" autofocus>

                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end">{{ __('main.email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">{{ __('main.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-end">{{ __('main.confirm_password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="text-center mb-3">
                                <input type="checkbox" name="policy" required id="policy">
                                <label for="policy">{{ __('main.accept_policy') }} <a href="/rules">{{ __('main.rules') }}</a> {{ __('main.and') }} <a href="/policy">{{ __('main.policy') }}</a></label>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-secondary">
                                        {{ __('main.register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

<script>
    function showSurname(val){
        let block = document.querySelector('.surname-block')
        if (val === 'person'){
            block.style.display = 'flex'
            document.querySelector('.company-name').innerHTML = "{{ __('main.name') }}"
            document.getElementById('surname').setAttribute('required', 'true')
        }
        else {
            block.style.display = 'none'
            document.getElementById('surname').value = ''
            document.querySelector('.company-name').innerHTML = "{{ __('main.company_name') }}"
            document.getElementById('surname').removeAttribute('required')
        }
    }
</script>
