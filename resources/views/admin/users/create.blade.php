@extends('layouts.admin')

@section('content')
    <create-user :countries = "{{ $countries }}":services="{{ $services }}" :professions="{{ $professions }}" :subcategories="{{ $subcategories }}"
        :langs="{{ $langs }}"
    ></create-user>
@endsection
