@extends('shared.layout')
@section('title', 'Dashboard')

@section('content')


    <h1 class="capitalize text-gray-1100 font-bold text-[28px] leading-[35px] mb-[13px] dark:text-gray-dark-1100">
        Welcome {{config('APP_NAME')}}
    </h1>
    <p class="text-gray-500"> This app offers you effortless and easy content management </p>
    <p class="text-xs text-gray-500"> App Version: {{config('APP_VERSION')}} </p>
@endsection
