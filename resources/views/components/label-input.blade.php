@props(['for', 'text', 'type', 'id', 'name', 'placeholder'=>'', 'isRequired'=>'yes', 'value'=>''])

@php
    if($isRequired == 'yes'){
        $isRequired = "required";
    }
@endphp

<div class="mb-4">
    <label for="{{$for}}" class="block text-dark-pink font-semibold mb-2" {{$isRequired}}>{{$text}}</label>

    @if($type == 'textarea')
        <textarea id='{{$id}}' name='{{$name}}' rows='4' class='w-full bg-white border border-gray-300 rounded-lg px-4 py-2' placeholder='{{$placeholder}}'></textarea>
    @else
        <input type='{{$type}}' id='{{$id}}' name='{{$name}}' class='w-full bg-white border border-gray-300 rounded-lg px-4 py-2' placeholder='{{$placeholder}}' value="{{$value}}">
    @endif
</div>
