@props(['value', 'isDisabled' => '', 'isSelected'=>''])

@php
    if($isDisabled == 'yes'){
        $isDisabled = "disabled selected";
    }
    if ($isSelected == 'yes') {
        $isSelected = 'selected';
    }
@endphp

<option class="bg-brighter-peach" value="{{$value}}" {{$isDisabled}} {{$isSelected}}>{{$slot}}</option>
