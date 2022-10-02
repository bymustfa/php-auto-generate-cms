<?php $requestURI = $_SERVER['REQUEST_URI'] ?>
@include('shared.header')
<div class="wrapper mx-auto text-gray-900 font-normal {{!strpos($requestURI, 'login') ? "grid grid-cols-[257px,1fr] grid-rows-[auto,1fr]":""  }}"
     id="layout">

    <?php
    if (!strpos($requestURI, 'login')){
        ?>
    @include('shared.asside')
    @include('shared.top-bar')
    <?php } ?>


    <main class="overflow-x-scroll scrollbar-hide flex flex-col justify-between pt-[42px] px-[23px] pb-[28px]"
          style="min-height: 100vh;">
        @include('shared.alert')
        <div>

            @yield('content')
        </div>
    </main>

</div>
@include('shared.footer')
