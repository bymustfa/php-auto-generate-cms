@extends('shared.layout')
@section('title', 'Login')

@section('content')




    <form class="rounded-2xl bg-white mx-auto p-10  max-w-[440px] my-[84px] dark:bg-[#1F2128]"
          action="{{base_url("login")}}"
          method="POST">

        <div class="mb-4 text-center mx-auto">
            <img class="inline-block"
                 src="{{assets('images/icons/icon-landing-success-1.svg')}}"
                 alt="landing success">
        </div>
        <div class="text-center">
            <h3 class="font-bold text-2xl text-gray-1100 capitalize mb-[5px] dark:text-gray-dark-1100">welcome
                back!</h3>
            <p class="text-sm text-gray-500 mb-[30px] dark:text-gray-dark-500">Let’s build something greate</p>

        </div>

        <div>

            @include('components.form.input', ['label' => 'Username', 'placeholder' => 'Username', 'required' => true, 'name' => 'username'])
            @include('components.form.input', ['label' => 'Password', 'placeholder' => 'Password', 'required' => true, 'name' => 'password', 'type' => 'password'])


        </div>
        <button class="btn normal-case h-fit min-h-fit transition-all duration-300 border-4 hover:border-[#B2A7FF] hover:bg-color-brands dark:hover:border-[#B2A7FF] w-full border-neutral-bg mb-[20px] py-[14px] dark:border-dark-neutral-bg"
                type="submit">
            Login
        </button>

    </form>


@endsection
