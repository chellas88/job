@extends('layouts.admin')

@section('content')
    <div class="container">

        <div class="card mt-3">
            <div class="card-header">
                {{ $user['name'].' '. $user['surname'] }}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-5 mb-3">
                        <label>Тип аккаунта</label>
                        <select name="role" class="form-control" disabled>
                            <option value="" disabled>Выберите тип аккаунта</option>
                            <option value="person" {{ ($user['role'] == 'person') ? 'selected' : '' }}>Физ. лицо
                            </option>
                            <option value="company" {{ ($user['role'] == 'company') ? 'selected' : '' }}>Компания
                            </option>
                        </select>
                    </div>
                    <div class="col-7"></div>
                    <div class="col-4 mb-3">
                        @if ($user['role'] == 'company')
                            <label>Название компании</label>
                        @elseif ($user['role'] == 'person')
                            <label>Имя</label>
                        @endif
                        <input type="text" name="name" class="form-control" value="{{ $user['name'] }}">
                    </div>
                    <div class="col-4 mb-3">
                        @if ($user['role'] == 'person')
                            <label>Фамилия</label>
                            <input type="text" name="surname" class="form-control" value="{{ $user['surname'] }}">
                        @endif
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4 mb-3">
                        <label for="country">Страна</label>
                        <select id="country" class="form-control" name="country_id" required>
                            <option value="" disabled>Выберите страну</option>
                            @foreach($countries as $country)
                                <option value="{{ $country['id'] }}" {{ ($country['id'] == $user['country_id']) ? 'selected' : '' }}>{{ $country['title_ru'] }}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="city">Город</label>
                        <input id="city" class="form-control" name="city" value="{{ $user['city'] }}">
                    </div>
                    <div class="col-4">
                        <label for="address">Адрес</label>
                        <input id="address" class="form-control" name="address" value="{{ $user['address'] }}">
                    </div>
                    <div class="col-4 mb-3">
                        <label>Направление</label>
                        <select name="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category['id'] }}" {{ $category['id'] == $user['category_id'] ? 'selected' : '' }}>{{ $category['title_ru'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-8"></div>
                    <div class="col-4 mb-3">
                        <label>{{ ($user['role'] == 'person') ? 'Профессия 1' : 'Услуга 1'}}</label>
                        <select name="prof_1" class="form-control">
                            <option value="">Выберите профессию</option>
                            @foreach($services as $service)
                                <option value="{{ $service['id'] }}" {{ ((isset($prof[1])) && ($prof[1]['id'] == $service['id'])) ? 'selected' : '' }} >{{ $service['title_ru'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label>{{ ($user['role'] == 'person') ? 'Профессия 2' : 'Услуга 2'}}</label>
                        <select name="prof_2" class="form-control">
                            <option value="">Выберите профессию</option>
                            @foreach($services as $service)
                                <option value="{{ $service['id'] }}" {{ ((isset($prof[2])) && ($prof[2]['id'] == $service['id'])) ? 'selected' : '' }} >{{ $service['title_ru'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label>{{ ($user['role'] == 'person') ? 'Профессия 3' : 'Услуга 3'}}</label>
                        <select name="prof_3" class="form-control">
                            <option value="">Выберите профессию</option>
                            @foreach($services as $service)
                                <option value="{{ $service['id'] }}" {{ ((isset($prof[3])) && ($prof[3]['id'] == $service['id'])) ? 'selected' : '' }} >{{ $service['title_ru'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Язык 1</label>
                        <select name="lang_1" class="form-control">
                            <option value="">Выберите язык</option>
                            @foreach($languages as $lan){
                            <option value="{{ $lan['id'] }}" {{ ((isset($lang[1])) && ($lang[1]['id'] == $lan['id'])) ? 'selected' : ''}}>{{ $lan['title_ru'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Язык 2</label>
                        <select name="lang_2" class="form-control">
                            <option value="">Выберите язык</option>
                            @foreach($languages as $lan){
                            <option value="{{ $lan['id'] }}" {{ ((isset($lang[2])) && ($lang[2]['id'] == $lan['id'])) ? 'selected' : ''}}>{{ $lan['title_ru'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Язык 3</label>
                        <select name="lang_3" class="form-control">
                            <option value="">Выберите язык</option>
                            @foreach($languages as $lan){
                            <option value="{{ $lan['id'] }}" {{ ((isset($lang[3])) && ($lang[3]['id'] == $lan['id'])) ? 'selected' : ''}}>{{ $lan['title_ru'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Описание</label>
                        <textarea class="form-control"></textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Описание</label>
                        <textarea class="form-control"></textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Описание</label>
                        <textarea class="form-control"></textarea>
                    </div>

                    <hr class="mt-3 mb-3">
                    <h5>Контакты</h5>

                </div>
            </div>
        </div>

    </div>







@endsection


