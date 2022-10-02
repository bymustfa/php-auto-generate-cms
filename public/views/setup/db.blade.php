@extends('shared.layout')
@section('title', 'Setup / Database')

@section('content')

    <div class="border bg-neutral-bg border-neutral dark:bg-dark-neutral-bg dark:border-dark-neutral-border rounded-2xl px-[25px] pt-[25px] pb-[68px]">
        <form class="flex flex-col gap-x-5 " action="{{ base_url("setup/db")}}"
              method="POST"    >

            @include('components.form.input', ['label' => 'Host', 'placeholder' => 'Host', 'required' => true, 'name' => 'host', 'value' =>  config("DB_HOST")])
            @include('components.form.input', ['label' => 'User', 'placeholder' => 'User', 'required' => true, 'name' => 'user', 'value' =>  config("DB_USER")])
            @include('components.form.input', ['label' => 'Password', 'placeholder' => 'Password', 'required' => true, 'name' => 'password', 'value' =>  config("DB_PASSWORD"), 'type' => 'password'])
            @include('components.form.input', ['label' => 'Name', 'placeholder' => 'Name', 'required' => true, 'name' => 'database', 'value' =>  config("DB_NAME")])
            @include('components.form.input', ['label' => 'Prefix', 'placeholder' => 'Prefix', 'required' => true, 'name' => 'prefix', 'value' =>  config("DB_PREFIX")])


            @include('components.form.button', ['text' => 'Save', 'type' => 'submit', 'iconName' => 'icon-save'])


        </form>
    </div>

@endsection
