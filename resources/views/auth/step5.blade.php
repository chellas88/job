@extends('layouts.app')

@section('content')
    <div class="col main-block">

        <img class="w-100 bg-bottom" src="{{ asset('/images/main-block-bottom.svg') }}">
    </div>
    <div class="container auth-block">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header">{{ __('main.registration_step_5') }}</div>

                    <div class="card-body languages lang-list">
                        {{ __('main.select_languages_text') }}
                        <languages :languages="{{ json_encode($languages, true) }}" :my-languages="{{ json_encode($myLanguages, true) }}"
                                   :translate="{{ json_encode($translate, true) }}" locale="{{ \Illuminate\Support\Facades\App::currentLocale() }}"
                        >

                        </languages>
{{--                            <div class="row px-3">--}}
{{--                                <div class="col mb-3">--}}
{{--                                    <p>{{ __('main.select_languages_text') }}</p>--}}
{{--                                    <select name="lang_1" class="p-1" onchange="selectLanguage(this)">--}}
{{--                                        <option value="">{{ __('main.select_language') }}</option>--}}
{{--                                        @foreach($languages as $language)--}}
{{--                                            <option key="{{ $language['key'] }}"--}}
{{--                                                    value="{{ $language['id'] }}">{{ $language['title_'.\Illuminate\Support\Facades\App::currentLocale()] }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="block_1 mb-3">--}}
{{--                                    <div class="mb-3" id="profile_title_1">{{ __('main.profile_title') }} <span></span>--}}
{{--                                        <input class="form-control" type="text" name="profile_title_1">--}}
{{--                                    </div>--}}
{{--                                    <label id="profile_text_1">{{ __('main.description') }} <span></span></label>--}}
{{--                                    <textarea name="description_1" class="form-control"></textarea>--}}
{{--                                    <input type="hidden" name="keylang_1">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row px-3">--}}
{{--                                <div class="col mb-3">--}}
{{--                                    <select name="lang_2" class="p-1" onchange="selectLanguage(this)">--}}
{{--                                        <option value="">{{ __('main.select_language') }}</option>--}}
{{--                                        @foreach($languages as $language)--}}
{{--                                            <option key="{{ $language['key'] }}"--}}
{{--                                                    value="{{ $language['id'] }}">{{ $language['title_'.\Illuminate\Support\Facades\App::currentLocale()] }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="block_2 mb-3">--}}
{{--                                    <div class="mb-3" id="profile_title_2">{{ __('main.profile_title') }} <span></span>--}}
{{--                                        <input class="form-control" type="text" name="profile_title_2">--}}
{{--                                    </div>--}}
{{--                                    <label id="profile_text_2">{{ __('main.description') }} <span></span></label>--}}
{{--                                    <textarea name="description_2" class="form-control"></textarea>--}}
{{--                                    <input type="hidden" name="keylang_2">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row px-3">--}}
{{--                                <div class="col mb-3">--}}
{{--                                    <select name="lang_3" class="p-1" onchange="selectLanguage(this)">--}}
{{--                                        <option value="">{{ __('main.select_language') }}</option>--}}
{{--                                        @foreach($languages as $language)--}}
{{--                                            <option key="{{ $language['key'] }}"--}}
{{--                                                    value="{{ $language['id'] }}">{{ $language['title_'.\Illuminate\Support\Facades\App::currentLocale()] }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="block_3 mb-3">--}}
{{--                                    <div class="mb-3" id="profile_title_3">{{ __('main.profile_title') }} <span></span>--}}
{{--                                        <input class="form-control" type="text" name="profile_title_3">--}}
{{--                                    </div>--}}
{{--                                    <label id="profile_text_3">{{ __('main.description') }} <span></span></label>--}}
{{--                                    <textarea name="description_3" class="form-control"></textarea>--}}
{{--                                    <input type="hidden" name="keylang_3">--}}
{{--                                </div>--}}
{{--                            </div>--}}


                            <div class="row mb-0">
                                <div class="col-md-12 text-center">
                                    <a href="{{ route('home') }}"><button class="btn btn-secondary">
                                        {{ __('main.finish_registration') }}
                                        </button></a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


<script>
    function selectLanguage(select) {
        let language = @json($languages).
        filter(item => select.value == item.id)[0]
        let block = select.name.split('_')[1]
        if (select.value) {
            document.querySelector('.block_' + block).style.display = 'inline'
            document.querySelector('#profile_title_' + block + ' span').innerHTML = '(' + language.key + ')'
            document.querySelector('#profile_text_' + block + ' span').innerHTML = '(' + language.key + ')'
            document.querySelector('[name="keylang_' + block +'"]').value = language.key
        }
        else {
            document.querySelector('.block_' + block).style.display = 'none'
            document.querySelector('#profile_title_' + block + ' span').innerHTML = ''
            document.querySelector('[name="profile_title_' + block +'"]').value = ''
            document.querySelector('[name="description_' + block +'"]').value = ''
        }
    }
</script>

<style>
    .block_1, .block_2, .block_3 {
        display: none;
    }
    #profile_title_1 span , #profile_text_1 span{
        text-transform: uppercase;
    }
    #profile_title_2 span , #profile_text_2 span{
        text-transform: uppercase;
    }
    #profile_title_3 span , #profile_text_3 span{
        text-transform: uppercase;
    }
</style>
