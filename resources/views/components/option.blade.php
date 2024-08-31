@props(['value', 'isDisabled' => ''])

@php
    if($isDisabled == 'yes'){
        $isDisabled = "disabled selected";
    }
@endphp

<option class="bg-brighter-peach" value="{{$value}}" {{$isDisabled}}>{{$slot}}</option>
