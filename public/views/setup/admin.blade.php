@extends('shared.layout')
@section('title', 'Setup / Admin')

@section('content')

    <div class="border bg-neutral-bg border-neutral dark:bg-dark-neutral-bg dark:border-dark-neutral-border rounded-2xl px-[25px] pt-[25px] pb-[68px]">
        <form class="flex flex-col gap-x-5 " action="{{ base_url("setup/admin") }}"
              method="POST">

            @include('components.form.input', ['label' => 'Name', 'placeholder' => 'Name', 'required' => true, 'name' => 'name', 'value' =>  $superAdmin->superadmin_name])
            @include('components.form.input', ['label' => 'Password', 'placeholder' => 'Password', 'required' => true, 'name' => 'password', 'value' =>  '', 'type' => 'password'] )


            @include('components.form.button', ['text' => 'Save', 'type' => 'submit', 'iconName' => 'icon-save'])


        </form>
    </div>

@endsection
