@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row py-2 justify-content-around">
            <div class="col-3 card p-2 shadow m-0">
                <div class="d-flex dashboard-block align-items-center justify-content-between">
                    <div class="p-2">
                        <h5>Физ. лица</h5>
                        <span>Количество персональных аккаунтов, зарегистрированных в системе</span>
                    </div>
                    <div class="count">{{ $personsCount }}</div>
                </div>
            </div>
            <div class="col-3 card p-2 shadow m-0">
                <div class="d-flex dashboard-block align-items-center justify-content-between">
                    <div class="p-2">
                        <h5>Компании</h5>
                        <span>Количество компаний, зарегистрированных в системе</span>
                    </div>
                    <div class="count">{{ $companiesCount }}</div>
                </div>
            </div>
            <div class="col-3 card p-2 shadow m-0">
                <div class="d-flex dashboard-block align-items-center justify-content-between">
                    <div class="p-2">
                        <h5>Отзывы</h5>
                        <span>Количество опубликованных на сайте отзывов</span>
                    </div>
                    <div class="count">{{ $reviewsCount }}</div>
                </div>
            </div>
        </div>

        <div class="row mt-4 dashboard-panel p-2">
            <div class="col-8 p-2">
                <h5>Не приняли соглашение</h5>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Имя (название компании)</th>
                        <th scope="col">Дата регистрации</th>
                        <th scope="col">Handle</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($noPolicy as $user)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $user['name'] .' '. $user['surname'] }}</td>
                            <td>{{ $user['created_at'] }}</td>
                            <td>@mdo</td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>

            <div class="col-4 p-2 reviews">
                <h5>Отзывы (ожидает модерацию)</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


