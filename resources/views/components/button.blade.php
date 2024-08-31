@props(['type' => ''])

<button type="{{$type}}" {{$attributes(['class' => 'bg-dark-pink text-white rounded hover:bg-pink transition'])}}">{{$slot}}</button>
