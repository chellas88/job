@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col py-3">
                <h3>Категории</h3>
            </div>
            <div class="col-12 py-2 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSubCategoryModal">
                    Новая подкатегория
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
                    Новая категория
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
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category['title_'. \Illuminate\Support\Facades\App::currentLocale()] }}</td>
                            <td>
                                <div class="accordion accordion-flush" id="accordion_{{$category['id']}}">
                                    <div class="accordion-item">
                                        <h4 class="accordion-header p-0" id="flush-heading-{{$category['id']}}">
                                            <button class="accordion-button collapsed p-2" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapse-{{$category['id']}}"
                                                    aria-expanded="false"
                                                    aria-controls="flush-collapse-{{$category['id']}}">
                                                Показать подкатегории
                                            </button>
                                        </h4>
                                        <div id="flush-collapse-{{$category['id']}}" class="accordion-collapse collapse"
                                             aria-labelledby="flush-heading-{{$category['id']}}"
                                             data-bs-parent="#accordion_{{$category['id']}}">
                                            <div class="accordion-body p-1 d-table w-100 justify-content-between small">
                                                @if(!$category->subcategories->isEmpty())
                                                    @foreach($category->subcategories as $sub)
                                                        <div class="d-flex p-2 border-bottom-1 justify-content-between">
                                                            <span>{{ $sub['title_'. \Illuminate\Support\Facades\App::getLocale()] }}</span>
                                                            <a href="#" class="text-decoration-none remove-btn mx-0"
                                                               onclick="event.preventDefault(); document.getElementById('remove-sub-form-{{$sub['id']}}').submit();"
                                                            >
                                                                <i class="icon-trash text-danger"></i>
                                                            </a>
                                                            <form id="remove-sub-form-{{$sub['id']}}"
                                                                  action="{{ route('subcategory.destroy', $sub['id']) }}"
                                                                  method="POST" class="d-none">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                            </form>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </td>
                            <td class="text-end">
                                <a href="#" class="text-decoration-none edit-btn" category="{{ $category['id'] }}"
                                   data-bs-target="#editCategoryModal" data-bs-toggle="modal"
                                   @foreach(config('app.locales') as $lang)
                                   value_{{$lang}}="{{ $category['title_'. $lang] }}"
                                    @endforeach
                                    user_type="{{ $category['user_type'] }}"
                                >
                                    <i class="icon-edit text-info"></i>
                                </a>
                                <a href="#" class="text-decoration-none remove-btn" category="{{ $category['id'] }}"
                                   data-bs-target="#removeCategoryModal" data-bs-toggle="modal"
                                   text="{{$category['title_'. \Illuminate\Support\Facades\App::getLocale()]}}"
                                >
                                    <i class="icon-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $categories->appends(request()->query())->links() }}
            </div>
        </div>

    </div>





    <!-- Modal New Category -->
    <div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('category.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Новая категория</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_type">Тип профиля</label>
                            <select id="user_type" name="user_type" class="form-control">
                                <option value="person">Физ. лицо</option>
                                <option value="company">Компания</option>
                            </select>
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

    <!-- Modal Edit Category -->
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

    <!-- Modal Remove Category -->
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

    <!-- Modal New SubCategory -->
    <div class="modal fade" id="newSubCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('subcategory.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Новая подкатегория</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="category_id">Категория</label>
                            <select id="category_id" name="category_id" class="form-control" required>
                                <option value="" disabled selected>Выберите категорию</option>
                                @foreach($categoryList as $cat)
                                    <option
                                        value="{{$cat['id']}}">{{$cat['title_'.\Illuminate\Support\Facades\App::getLocale()]}}</option>
                                @endforeach
                            </select>
                        </div>
                        @foreach(config('app.locales') as $lang)
                            <div class="mb-3">
                                <label for="sub_name_{{$lang}}">Название ({{$lang}})</label>
                                <input type="text" id="sub_name_{{$lang}}" name="title_{{$lang}}" class="form-control" required>
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
