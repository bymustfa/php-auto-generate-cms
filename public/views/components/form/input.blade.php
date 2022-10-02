@php
    $id = $id ?? $name."-".uniqid();
@endphp
<div class="w-full mb-5">
    <label class="text-gray-1100 text-base leading-4 font-medium capitalize mb-[10px] dark:text-gray-dark-1100">
        {{$label}}
    </label>
    <div class="input-group border rounded-lg border-[#E8EDF2] dark:border-[#313442] w-full">
        <input type="{{isset($type) ? $type  : "text"}}"
               id="{{ $id}}"
               name="{{ isset($name) ? $name : ""}}"
               placeholder="{{isset($placeholder) ? $placeholder : ""}}"
               required="{{isset($required) ? $required : false}}"
               value="{{ isset($value) ? $value : ""}}"
               class="input bg-transparent text-sm leading-4 text-gray-400 h-fit min-h-fit py-4 focus:outline-none pl-[13px] dark:text-gray-dark-400 w-full
                {{isset($className)? $className : ""}}"/>
        {!!
    isset($type) && $type == "password" ?
      '<span class="password-toggle" data-show="0"
                data-id="'.$id.'">
                <img
                    on-src="'.assets('images/icons/icon-eye-off.svg').'"
                    off-src="'.assets('images/icons/icon-eye.svg').'"
                    src="'.assets('images/icons/icon-eye.svg').'" alt="icon-eye" class="cursor-pointer absolute right-[13px] top-[13px]">
                </span> ' : ""
    !!}
    </div>
</div>
