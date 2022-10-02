@extends('shared.layout')
@section('title', 'Setup')

@section('content')
    <div class="category-list">
        <div class="w-[30%] bg-neutral h-[1px] mb-[21px] dark:bg-dark-neutral-border"></div>
        <h3 class="text-sm font-bold text-gray-1100 py-3 px-6 dark:text-gray-dark-1100">Setup List</h3>
        <div>
            <a class="flex items-center justify-between py-3 pl-6" href="{{base_url('setup/db')}}">
                <span class="text-gray-500 text-normal dark:text-gray-dark-500">Database Setup</span>
            </a>

            <a class="flex items-center justify-between py-3 pl-6" href="{{base_url('setup/admin')}}">
                <span class="text-gray-500 text-normal dark:text-gray-dark-500">Admin Setup</span>
            </a>


        </div>

    </div>
@endsection
