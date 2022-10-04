<aside class="bg-white row-span-2 border-r border-neutral relative flex flex-col justify-between p-[25px] dark:bg-dark-neutral-bg dark:border-dark-neutral-border">
    <div class="absolute p-2 border-neutral right-0 border bg-white rounded-full cursor-pointer duration-300 translate-x-1/2 hover:opacity-75 dark:bg-dark-neutral-bg dark:border-dark-neutral-border"
         id="sidebar-btn"><img src="{{assets('images/icons/icon-arrow-left.svg')}}" alt="left chevron icon"></div>
    <div>
        <a class="mb-10" href="{{base_url()}}">
            <img class="logo-maximize" src="{{assets('images/icons/icon-logo.svg')}}"
                 alt="Frox logo">
            <img class="logo-minimize ml-[10px]" src="{{assets('images/icons/icon-favicon.svg')}}" alt="Frox logo">
        </a>

        <div class="pt-[106px] lg:pt-[35px] pb-[18px]">

            @include('components.menu.list-menu', [ 'title' => 'Content Manager', 'href' => 'content', 'iconName' => 'icon-cms'  ])
            @include('components.menu.list-menu', [ 'title' => 'Media Library', 'href' => 'media/list', 'iconName' => 'icon-insert-image'])
            <div class="divider"></div>
            @include('components.menu.list-menu', [ 'title' => 'Setup', 'href' => 'setup', 'iconName' => 'icon-flash'])




        </div>


        <div class="w-full bg-neutral h-[1px] mb-[35px] dark:bg-dark-neutral-border"></div>


    </div>


</aside>
