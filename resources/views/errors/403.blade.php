@extends('errors::layout')

@php
    $err = $exception->getMessage();
    // dd($err);
@endphp

@section('title', __('Forbidden'))
@section('message')
    <p>@lang("Oops! The page you are looking for is not authorized.")</p>
    {{-- {{  dd($err) }} --}}
    <p style='color:grey; font-size: 13px;'> (<i>Erreur <b>403</b> | @lang('Forbidden')</i>).
    </p>
    <p>@lang('Return to ')<a href="/">@langL('Home page')</a>.</p>
@endsection
