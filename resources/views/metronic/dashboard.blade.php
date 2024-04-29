@extends('metronic.layouts.admin')

@section('')
@section('title')
    Dashboard
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('manage.dashboard') }}
@endsection

@section('content')

@endsection

@section('scripts')
    @parent

@endsection
