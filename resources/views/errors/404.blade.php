@extends('errors::layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
        <p>@lang("The page you're looking for can't be found.")</p>
        <p>@lang('Return to ')<a href="/">@lang('home page')</a>.</p>
@endsection