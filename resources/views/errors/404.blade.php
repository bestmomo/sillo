@extends('errors::layout')

@php
        $err = json_decode($exception->getMessage());
@endphp

@section('title', __('Not Found'))
@section('message')
        <p>@lang("The page you're looking for can't be found.")</p>
        {{-- {{  dd($err) }} --}}
        <p style='color:grey; font-size: 13px;'> (<i>"<b>{{ $err[0] }}</b>", @langL('To') {{ $err[1] }}</i>).</p>
        <p>@lang('Return to ')<a href="/">@langL('Home page')</a>.</p>
@endsection

