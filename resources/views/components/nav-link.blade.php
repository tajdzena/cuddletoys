@props(['putanja', 'weight' => 'bold'])

@php
    $classes = "text-md block rounded-lg px-2 py-1 leading-6 text-dark-pink hover:bg-white/20 transition";
    if($weight == "bold"){
        $classes .= " font-bold";
    }
    if($weight == "semibold"){
        $classes .= " font-semibold";
    }
@endphp

<a href="{{$putanja}}" class="{{$classes}}">{{$slot}}</a>
