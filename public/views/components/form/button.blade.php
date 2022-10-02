<button
        type="{{isset($type) ? $type : "button"}}"
        class="btn flex items-center normal-case bg-color-brands h-auto border-white rounded-2xl border-gray-100 gap-x-[10.5px] border-[4px] hover:border-[#B2A7FF] hover:bg-color-brands dark:border-black dark:hover:border-[#B2A7FF] p-[17.5px]
         {{isset($className)? $className : ""}}
         ">
    {!! isset($iconName)? '<img src="'.assets('images/icons/'.$iconName.'.svg').'" alt="'.$iconName.'">' : "" !!}
    {!! $text !!}
</button>
