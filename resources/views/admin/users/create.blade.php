@extends('layouts.admin')

@section('content')
    <create-user :countries = "{{ $countries }}":services="{{ $services }}" :professions="{{ $professions }}" :subcategories="{{ $subcategories }}"
        :langs="{{ $langs }}" :old="{{ json_encode(Session::getOldInput()) }}"
    ></create-user>
@endsection
