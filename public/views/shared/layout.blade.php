@include('shared.header')
<div class="wrapper mx-auto text-gray-900 font-normal grid grid-cols-[257px,1fr] grid-rows-[auto,1fr]" id="layout">
    @include('shared.asside')
    @include('shared.top-bar')
    <main class="overflow-x-scroll scrollbar-hide flex flex-col justify-between pt-[42px] px-[23px] pb-[28px]" style="min-height: 100vh;">
        <div>

            @yield('content')
        </div>
    </main>

</div>
@include('shared.footer')
