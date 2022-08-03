@extends('layouts.app')

@section('content')
    <div class="col main-block">

        <img class="w-100 bg-bottom" src="{{ asset('/images/main-block-bottom.svg') }}">
    </div>
    <div class="container auth-block">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header">{{ __('main.registration_step_4') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('step_4_save') }}">
                            @csrf
                            <div class="row p-3">
                                <div class="col-5">
                                    <div class="row mb-3">
                                        <label for="phone">{{ __('main.phone') }}</label>
                                        <input type="text" id="phone" name="phone" class="form-control" required>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="viber">{{ __('main.viber') }}</label>
                                        <input type="text" id="viber" name="viber" class="form-control">
                                    </div>
                                    <div class="row mb-3">
                                        <label for="telegram">{{ __('main.telegram') }}</label>
                                        <input type="text" id="telegram" name="telegram" class="form-control">
                                    </div>
                                    <div class="row mb-3">
                                        <label for="whatsapp">{{ __('main.whatsapp') }}</label>
                                        <input type="text" id="whatsapp" name="whatsapp" class="form-control">
                                    </div>
                                    <div class="row mb-3">
                                        <label for="skype">{{ __('main.skype') }}</label>
                                        <input type="text" id="skype" name="skype" class="form-control">
                                    </div>
                                </div>
                                <div class="col-2"></div>
                                <div class="col-5">
                                    <div class="row mb-3">
                                        <label for="facebook">{{ __('main.facebook') }}</label>
                                        <input type="text" id="facebook" name="facebook" class="form-control">
                                    </div>
                                    <div class="row mb-3">
                                        <label for="instagram">{{ __('main.instagram') }}</label>
                                        <input type="text" id="instagram" name="instagram" class="form-control">
                                    </div>
                                    <div class="row mb-3">
                                        <label for="youtube">{{ __('main.youtube') }}</label>
                                        <input type="text" id="youtube" name="youtube" class="form-control">
                                    </div>
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



