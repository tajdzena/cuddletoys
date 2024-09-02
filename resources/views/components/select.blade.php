@props(['id', 'name'=>''])

<select id="{{$id}}" name="{{$name}}" class="w-max bg-white/70 border border-gray-300 rounded-lg px-4 py-2">
    {{$slot}}
</select>
