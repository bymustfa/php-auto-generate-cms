<div class="sidemenu-item rounded-xl relative {{activeClass($href)  }}">
    <a href="{{base_url($href)}}"
       class="flex items-center justify-between w-full cursor-pointer py-[17px] px-[21px] focus:outline-none peer-checked:border-transparent ">
        <div class="flex items-center gap-[10px]">
            {!! isset($iconName)? '<img src="'.assets('images/icons/'.$iconName.'.svg').'" alt="'.$iconName.'">' : "" !!}
            <span class="text-normal font-semibold text-gray-500 sidemenu-title dark:text-gray-dark-500">{{$title}}</span>
        </div>
    </a>
</div>
