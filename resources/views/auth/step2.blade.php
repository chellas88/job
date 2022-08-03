@extends('layouts.app')

@section('content')
    <div class="col main-block">

        <img class="w-100 bg-bottom" src="{{ asset('/images/main-block-bottom.svg') }}">
    </div>
    <div class="container auth-block">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">{{ __('main.registration_step_2') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('step_2_save') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="category">{{ __('main.category') }}</label>
                                <select id="category" name="category_id" class="form-control"
                                        onchange="services(this.value)" required>
                                    <option value="" disabled selected>{{ __('main.select_category') }}</option>
                                    @foreach($categories as $category)
                                        <option
                                            value="{{ $category['id'] }}">{{ $category['title_'. \Illuminate\Support\Facades\App::currentLocale()] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row mb-3 d-none subcategory-row">
                                <label>{{ ($user['role'] == 'person') ? __('main.profession') : __('main.service') }}</label>
                                <select name="subcategory_1" class="form-control subcategory">
                                </select>
                            </div>

                            <div class="row mb-3 d-none subcategory-row">
                                <label>{{ ($user['role'] == 'person') ? __('main.profession') : __('main.service') }}</label>
                                <select name="subcategory_2" class="form-control subcategory">
                                </select>
                            </div>

                            <div class="row mb-3 d-none subcategory-row">
                                <label>{{ ($user['role'] == 'person') ? __('main.profession') : __('main.service') }}</label>
                                <select name="subcategory_3" class="form-control subcategory">
                                </select>
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


<script>
    function services(category_id) {
        if (category_id){
            console.log(category_id)
            Array.prototype.forEach.call(document.getElementsByClassName('subcategory-row'), function(row){
                row.classList.remove('d-none')
                console.log(row)
            })
        }
        let selects = document.getElementsByClassName('subcategory')
        let subcategories = @json($services);
        let list = []
        subcategories.forEach(item => {
            if (+item.category_id === +category_id){
                list.push(item)
            }
        })
        Array.prototype.forEach.call(selects, function (select) {
            select.innerHTML = ''
            select.options.add(new Option( '@lang('main.select_profession')', '',))
            list.forEach(subcategory => {
                select.options.add(new Option(subcategory['title_ru'], subcategory['id']))
            })
        })
    }
</script>
