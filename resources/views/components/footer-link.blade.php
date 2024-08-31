@props(['putanja', 'target'=>''])

@php
    if($target == '_blank'){
        $target = '_blank';
    }
@endphp

<li class="heart-bullet"><a href="{{$putanja}}" target="{{$target}}" class="text-dark-pink text-md hover:text-brighter-peach/50 transition">{{$slot}}</a></li>
