<header class="flex items-center justify-between  bg-neutral-bg p-5 gap-5 md:py-6 md:pl-[25px] md:pr-[38px] lg:flex-nowrap dark:bg-dark-neutral-bg lg:gap-0">


    <h2 class="capitalize text-gray-1100 font-bold text-[28px] leading-[35px] mb-[13px] dark:text-gray-dark-1100">
        @yield('title', "")
    </h2>


    <div class="flex items-center justify-content-end " style="justify-content: flex-end;">


        <div class="flex items-center gap-3 mr-5"><i class="moon-icon" id="theme-toggle-dark-icon"><img
                        class="cursor-pointer" src="{{assets('images/icons/icon-moon.svg')}}" alt="moon icon"><img
                        class="cursor-pointer" src="{{assets('images/icons/icon-moon-active.svg')}}"
                        alt="moon icon"></i>
            <label class="flex items-center cursor-pointer" for="theme-toggle" id="toggle-theme-btn">
                <div class="relative">
                    <input class="sr-only peer" type="checkbox" name="" id="theme-toggle">
                    <div class="block rounded-full w-[48px] h-[16px] bg-gray-300 peer-checked:bg-[#B2A7FF]"></div>
                    <div class="dot dotS absolute rounded-full transition h-[24px] w-[24px] top-[-4px] left-[-4px] bg-[#B2A7FF] peer-checked:bg-color-brands"></div>
                </div>
            </label><i class="sun-icon" id="theme-toggle-light-icon">
                <img class="cursor-pointer" src="{{assets('images/icons/icon-sun.svg')}}" alt="sun icon">
                <img class="cursor-pointer" src="{{assets('images/icons/icon-sun-active.svg')}}" alt="sun icon">
            </i>
        </div>


        <div class="flex items-center order-2 user-noti gap-[30px] xl:gap-[48px] lg:order-3 lg:mr-0">

            <div class="dropdown dropdown-end">
                <label class="cursor-pointer dropdown-label" tabindex="0"><img
                            src="{{assets('images/avatar-layouts-5.png')}}"
                            alt="user avatar">
                </label>
                <ul class="dropdown-content" tabindex="0">
                    <div class="relative menu rounded-box dropdown-shadow p-[25px] pb-[10px] bg-neutral-bg mt-[25px] md:mt-[40px] min-w-[237px] dark:text-gray-dark-500 dark:border-dark-neutral-border dark:bg-dark-neutral-bg">
                        <div class="border-solid border-b-8 border-x-transparent border-x-8 border-t-0 absolute w-[14px] top-[-7px] border-b-neutral-bg dark:border-b-dark-neutral-bg right-[18px]"></div>
                        <li class="text-gray-500   dark:text-gray-dark-500   rounded-lg group p-[15px] pl-[21px]">
                            Hello, {{sesion()->get('superadmin_name')}}
                        </li>

                        <div class="w-full bg-neutral h-[1px] my-[7px] dark:bg-dark-neutral-border"></div>
                        <li class="text-gray-500 hover:text-gray-1100 hover:bg-gray-100 dark:text-gray-dark-500 dark:hover:text-gray-dark-1100 dark:hover:bg-gray-dark-100 rounded-lg group p-[15px] pl-[21px]">
                            <a class="flex items-center bg-transparent p-0 gap-[7px]" href="{{base_url('logout')}}">
                                <span>Log out</span>
                            </a>
                        </li>
                    </div>
                </ul>
            </div>

        </div>
    </div>


</header>
