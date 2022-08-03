@extends('layouts.app')

@section('content')
    <div class="col main-block">

        <img class="w-100 bg-bottom" src="{{ asset('/images/main-block-bottom.svg') }}">
    </div>
    <div class="container auth-block">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header">{{ __('main.registration_step_3') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('step_3_save') }}">
                            @csrf
                            <div class="row p-3">
                                    <div class="row mb-3">
                                        <label for="country">{{ __('main.country') }}</label>
                                        <input type="text" id="country" name="country" class="form-control" required>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="state">{{ __('main.state') }}</label>
                                        <input type="text" id="state" name="state" class="form-control">
                                    </div>
                                    <div class="row mb-3">
                                        <label for="city">{{ __('main.city') }}</label>
                                        <input type="text" id="city" name="city" class="form-control">
                                    </div>
                                    <div class="row mb-3">
                                        <label for="address">{{ __('main.address') }}</label>
                                        <input type="text" id="address" name="address" class="form-control">
                                    </div>
                            </div>



                            <div class="row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-secondary">
                                        {{ __('main.next') }}
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



