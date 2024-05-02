@extends('main.layouts.admin', [
])

@section('content')
    <input hidden id="CSRF_TOKEN" value="{{ csrf_token() }}">
@endsection
