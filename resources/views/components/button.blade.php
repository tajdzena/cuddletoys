@props(['type' => '', 'onclick' => '', 'id'=>'', 'name'=>''])

<button type="{{$type}}"
        {{$attributes(['class' => 'bg-dark-pink text-white rounded hover:bg-pink transition'])}}
        onclick="{{$onclick}}"
        id="{{$id}}"
        name="{{$name}}"
    >{{$slot}}
</button>
