@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col py-3">
                <h3>Список языков</h3>
            </div>
            <div class="col-12 py-2 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newModal">
                    Добавить язык
                </button>
            </div>
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Название</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($languages as $lang)
                        <tr>
                            <td>{{ $lang['title_'. \Illuminate\Support\Facades\App::currentLocale()] }}</td>
                            <td>
                            </td>
                            <td class="text-end">
                                <a href="#" class="text-decoration-none edit-btn"
                                   data-bs-target="#editCategoryModal" data-bs-toggle="modal"
                                >
                                    <i class="icon-edit text-info"></i>
                                </a>
                                <a href="#" class="text-decoration-none remove-btn"
                                   data-bs-target="#removeCategoryModal" data-bs-toggle="modal"
                                >
                                    <i class="icon-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{--                {{ $countries->appends(request()->query())->links() }}--}}
            </div>
        </div>

    </div>



    <!-- Modal New  -->
    <div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="newModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('language.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="newModalLabel">Добавить язык</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="lang-code">Lang Code</label>
                            <input type="text" id="lang-code" name="key" class="form-control">
                        </div>
                        @foreach(config('app.locales') as $lang)
                            <div class="mb-3">
                                <label for="name_{{$lang}}">Название ({{$lang}})</label>
                                <input type="text" id="name_{{$lang}}" name="title_{{$lang}}" class="form-control">
                            </div>
                        @endforeach

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Сохранить">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit  -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{route('category.update', 1)}}" id="update-form">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Изменить категорию</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_user_type">Тип профиля</label>
                            <select id="edit_user_type" name="user_type" class="form-control">
                                <option value="person">Физ. лицо</option>
                                <option value="company">Компания</option>
                            </select>
                        </div>
                        @foreach(config('app.locales') as $lang)
                            <div class="mb-3">
                                <label for="edit_name_{{$lang}}">Название ({{$lang}})</label>
                                <input type="text" id="edit_name_{{$lang}}" name="title_{{$lang}}" class="form-control">
                            </div>
                        @endforeach

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Сохранить">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Remove  -->
    <div class="modal fade" id="removeCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{route('category.destroy', 1)}}" id="remove-form">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Новая категория</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Вы действительно хотите удалить категорию "<b><span id="remove-name"></span></b>"
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-danger" value="Удалить">
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {

        //EDIT CATEGORY MODAL
        const editBtn = document.getElementsByClassName('edit-btn')
        Array.prototype.forEach.call(editBtn, btn => {
            btn.addEventListener('click', event => {
                let locales = @json(config('app.locales'));
                let category_id = btn.getAttribute('category')
                let user_type = btn.getAttribute('user_type')
                document.getElementById('edit_user_type').value = user_type

                locales.forEach(lang => {
                    let text = btn.getAttribute('value_' + lang)
                    document.getElementById('edit_name_' + lang).value = text
                    document.getElementById('update-form').setAttribute('action', '/en/admin/category/' + category_id)

                })
            })
        })

        //REMOVE CATEGORY MODAL
        const removeBtn = document.getElementsByClassName('remove-btn')
        const removeSpan = document.getElementById('remove-name')
        Array.prototype.forEach.call(removeBtn, btn => {
            btn.addEventListener('click', event => {
                let text = btn.getAttribute('text')
                let category_id = btn.getAttribute('category')
                removeSpan.innerHTML = text
                document.getElementById('remove-form').setAttribute('action', '/en/admin/category/' + category_id)

            })
        })

        //NEW SUBCATEGORY MODAL

    })
</script>
