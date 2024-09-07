@props(['value', 'isDisabled' => '', 'isSelected'=>'', 'data_image'=>'', 'data_price'=>''])

@php
    if($isDisabled == 'yes'){
        $isDisabled = "disabled selected";
    }
    if ($isSelected == 'yes') {
        $isSelected = 'selected';
    }
@endphp

<option class="bg-brighter-peach"
        value="{{$value}}"
        data-image="{{$data_image}}"
        data-price="{{$data_price}}"
        {{$isDisabled}}
        {{$isSelected}}>
    {{$slot}}
</option>
