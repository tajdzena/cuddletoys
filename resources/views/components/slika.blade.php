@props(['putanja', 'alt', 'h'=>'64'])

<img src="{{ asset($putanja) }}" alt="{{$alt}}" class="w-full h-{{$h}} object-cover rounded-md">
