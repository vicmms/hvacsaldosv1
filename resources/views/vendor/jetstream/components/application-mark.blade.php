@props(['color' => 'light', 'type' => 'small'])

@if ($type == 'large')
    <img class="w-32" style="margin-left: -5px"
    src="{{ asset('images/saldo-hvac-horizontal.png')}}"
    alt="saldos hvac">
@else
    <img class="w-12 h-12"
    src="{{ $color == 'light' ? asset('images/saldo-hvac-white.png') : asset('images/saldo-hvac-blue.png') }}"
    alt="saldos hvac">
@endif
