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
                        <th scope="col">Аккаунт</th>
                        <th scope="col">Оценка</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>{{ $review->toUser['name'] }}</td>
                            <td>
                                @if ($review['rank'] == 1)
                                    <x-rating.stars_1/>
                                @elseif ($review['rank'] == 2)
                                    <x-rating.stars_2/>
                                @elseif ($review['rank']  == 3)
                                    <x-rating.stars_3/>
                                @elseif ($review['rank']  == 4)
                                    <x-rating.stars_4/>
                                @elseif ($review['rank']  == 5)
                                    <x-rating.stars_5/>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="showReview({{ $review }})"
                                        data-bs-toggle="modal" data-bs-target="#review">Показать
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- new review -->
    <div class="modal fade" id="review" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" action="" id="form_publish">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3" id="review_author"><i>Автор:</i> <span></span></p>
                        <p class="mb-3" id="review_rank"><i>Оценка:</i> <span></span></p>
                        <p class="mb-3" id="review_text"><i>Текст:</i> <span></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Закрыть</button>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="submit" class="btn btn-primary" value="Опубликовать">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


<script>
    function showReview(review) {
        document.getElementById('reviewLabel').innerHTML = 'Отзыв #' + review.id
        document.querySelector('#review_author span').innerHTML = review.name
        document.querySelector('#review_rank span').innerHTML = review.rank
        document.querySelector('#review_text span').innerHTML = review.text
        document.getElementById('form_publish').setAttribute('action', '/en/review/' + review.id)
    }
</script>
