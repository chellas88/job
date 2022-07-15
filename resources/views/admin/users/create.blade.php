@extends('layouts.admin')

@section('content')

    @if ($errors->all())
        <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
        </div>
    @endif

    <create-user :countries = "{{ $countries }}":services="{{ $services }}" :professions="{{ $professions }}" :subcategories="{{ $subcategories }}"
        :langs="{{ $langs }}" :old="{{ json_encode(Session::getOldInput()) }} "
    ></create-user>
@endsection
